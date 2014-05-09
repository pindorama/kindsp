function displayBooks(response){
    response = JSON.parse(response);
    $("#booksResponse").html('');
    var booksHtml = '<div id="books">';
    for(var i in response.books){
      booksHtml +=  '<h3><a href="#">'+response.books[i].title+'</a></h3><div>written by'+response.books[i].author+'</div>';   
    }
    booksHtml += '</div>';
    $("#booksResponse").append(booksHtml);
    $("#booksResponse #books").accordion({"active":"none", "collapsible" : "true"});
    
    $("#currentPage").html(response.currentPage);
    
  updatePageLinks(response.currentPage);
    
}
/**
 * 
 * @param {type} page
 * @returns {undefined}
  */
 
function updatePageLinks(page){
    $("#previous").attr('page', page-1);
    $("#next").attr('page', page+1);
}

function getBooks(){
    var url = window.location.pathname + '/page/' + $(this).attr('page');
    $.post(url,
            {"format" : "json"},
             function(data){
                 displayBooks(data);
             },'html');
    return false;
}

$(document).ready(function() {
    $("a#next").click(getBooks);
    $("a#previous").click(getBooks);
    $("a#page").each(function(){
        $(this).click(getBooks);
    }); 
});


