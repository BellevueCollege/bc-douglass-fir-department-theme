<?php
/**
 * Course Description Shortcode Buttons and Modals
 *
 * @package BC Douglas Fir Theme
 */

/**************************************
 * Aggregate functions and WP actions
 **************************************/
// API URL.
define( 'API_MULTICOURSE_URL', 'http://www.bellevuecollege.edu/apis/classes/v1/courses/multiple' );


add_shortcode( 'coursedescription', 'coursedescription_func' );  // declare single course shortcode function
add_shortcode( 'multicoursedescription', 'multi_coursedescription_func' ); // declare multi course shortcode function

/*****************************
 * Single course functions
 *****************************/


// function for rendering single course shortcode into HTML
function coursedescription_func( $atts ) {
	$subject     = $atts['subject'];
	$course      = $atts['courseid'];// Attribute name should always read in lower case.
	$description = $atts['description'];
	if ( ! empty( $course ) && ! empty( $subject ) ) {
		$course_split  = explode( ' ', $course );
		$course_letter = $course_split[0];
		$course_id     = $course_split[1];
		$subject       = trim( html_entity_decode( $subject ) );
		// $url = "http://www.bellevuecollege.edu/classes/All/".$subject."?format=json";

		$url  = 'https://www2.bellevuecollege.edu/data/api/v1/course/' . urlencode( $subject ) . '/' . urlencode( trim( $course_id ) );
		$data = wp_remote_get( $url );

		if ( ! empty( $data ) && ! empty( $data['body'] ) && ! empty( $data['body'] ) ) {
			$json = json_decode( $data['body'] );
			$html = mayflower_decode_json_class_info( $json, $description );
			return $html;
		}
	}
	return null;
}

// process json returned by API call
function mayflower_decode_json_class_info( $json, $show_description = false ) {
	// return print_r( $course, true );
	$htmlString  = '';
	$htmlString .= '<div class="classDescriptions">';

	$htmlString .= mayflower_course_html( $json, $show_description );

	$htmlString .= '</div>'; // classDescriptions

	return $htmlString;
}


function mayflower_course_html( $data, $show_description = false ) {
	if ( isset( $data->course ) ) { // if there is course data, return course information
		$course = $data->course;
		$title  = $course->subject . ' '
		. $course->courseNumber . ': '
		. $course->title . ' - '
		. ( $course->isVariableCredits ? 'variable' : $course->credits ) . ' credits';

		$url = 'https://www2.bellevuecollege.edu/classes/All/' . $course->subject . '/' .
			$course->courseNumber;

		$description = $course->description;

		$more = 'View details for ' . $course->subject . ' '
			. $course->courseNumber;

		if ( $show_description && 'false' != $show_description ) {
			return "<h3><a href='$url'>$title</a></h3><p>$description</p><p><a href='$url'>$more</a></p>";
		} else {
			return "<h3><a href='$url'>$title</a></h3>";
		}
	} else { // if course not selected, return to inform user there are courses available
		return '<!-- No Course Available -->';
	}
}



// function for rendering multicourse shortcode into HTML
function multi_coursedescription_func( $atts ) {
	$courses = $atts['courses'];    // provided course ids
	// var_dump($courses);
	$description = $atts['description']; // whether to include descriptions
	if ( ! empty( $courses ) ) {
		// error_log("course :".$course);
		$course_split = explode( ',', $courses );
		$url          = API_MULTICOURSE_URL;

		// build query string for URL
		$qs = '';
		foreach ( $course_split as $course ) {
			if ( ! empty( $qs ) ) {
				$qs .= '&';
			}
			$qs .= 'courses[]=' . urlencode( html_entity_decode( strtoupper( $course ) ) );
		}
		$url .= '?' . $qs;

		$json = wp_remote_get( $url );    // make API call

		if ( ! empty( $json ) && ! empty( $json['body'] ) ) {
			$html = process_multicourse_json( $json['body'], $description ); // process returned json
			return $html;
		}
	}
	return null;
}

// process json returned by API call
function process_multicourse_json( $json_string, $description = null ) {
	$json = json_decode( $json_string, true );
	// var_dump($json);
	$html    = '';
	$courses = $json['courses'];
	$html   .= "<div class='classDescriptions'>";
	// loop through any returned courses and output each
	if ( count( $courses ) > 0 ) {
		foreach ( $courses as $course ) {
			$html .= get_course_html( $course, $description );
		}
	}
	$html .= '</div>'; // classDescriptions

	return $html;
}

// process individual course for display
function get_course_html( $course, $description = null ) {
	$html  = '';
	$html .= "<div class='class-info'>";
	$html .= "<h5 class='class-heading'>";

	$course_id = $course['subject'] . ' ' . $course['courseNumber'];

	$course_url = CLASSESURL . $course['subject'];
	/*
	if($course["isCommonCourse"])
	{
		$course_url .= "&";
	}*/
	$course_url .= '/' . $course['courseNumber'];

	$html .= "<a href='" . $course_url . "''>";
	$html .= "<span class='course-id'>" . $course_id . '</span>';
	$html .= " <span class='course-title'>" . $course['title'] . '</span>';
	$html .= "<span class='course-credits'> &#8226; ";

	if ( $course['isVariableCredits'] ) {
		$html .= 'V1-' . $course['credits'] . " <abbr title='variable credit'>Cr.</abbr>";
	} else {
		$html .= $course['credits'] . " <abbr title='credit(s)'>Cr.</abbr>";
	}
	$html .= '</span>';
	$html .= '</a>';
	$html .= '</h5>'; // classHeading
	if ( $description == 'true' && ! empty( $course['description'] ) ) {
		// error_log("Not here");
		$html .= "<p class='class-description'>" . $course['description'] . '</p>';
		$html .= "<p class='class-details-link'>";
		$html .= "<a href='" . $course_url . "'>View details for " . $course['subject'] . ' ' . $course['courseNumber'] . '</a>';
		$html .= '</p>';
	}
		$html .= '</div>'; // classInfo
		return $html;
}
