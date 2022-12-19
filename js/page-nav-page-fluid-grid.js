// init Masonry
var grid = document.querySelector('.child-pages');

if (grid != null){ //check if grid is not null/undefined then construct Masonry
    var msnry = new Masonry(grid, {
        itemSelector: '.child-pages article',
        columnWidth: '.child-pages .grid-sizer',
        percentPosition: true,
        horizontalOrder: true,
        gutter:10
    });
    
    imagesLoaded(grid).on('progress', function () {
        // layout Masonry after each image loads
        msnry.layout();
    });

}