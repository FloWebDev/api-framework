$(document).ready(function() {
	
    /* ===== Stickyfill ===== */
    /* Ref: https://github.com/wilddeer/stickyfill */
    // Add browser support to position: sticky
    var elements = $('.sticky');
    Stickyfill.add(elements);


    /* Activate scrollspy menu */
    $('body').scrollspy({target: '#doc-menu', offset: 100});
    
    /* Smooth scrolling */
	$('a.scrollto').on('click', function(e){
        //store hash
        var target = this.hash;    
        e.preventDefault();
		$('body').scrollTo(target, 800, {offset: 0, 'axis':'y'});
		
	});
     
    /* Bootstrap lightbox */
    /* Ref: http://ashleydw.github.io/lightbox/ */

    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(e) {
        e.preventDefault();
        $(this).ekkoLightbox();
    });    


});


// @fmathevon
var deleteButton = {
    ini: function() {
        var deleteButtons = document.querySelectorAll('.deleteButton');

        if(deleteButtons) {
            deleteButtons.forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function(e){
                    if (!confirm("Confirmez la suppression.")) {
                        e.preventDefault();
                    }
                });
            });
        }
    }
};
document.addEventListener('DOMContentLoaded', deleteButton.ini);

var deletePurge = {
    ini: function() {
        var deleteButton = document.querySelector('#deletePurge');

        if(deleteButton) {
            deleteButton.addEventListener('click', function(e) {
                if (!confirm("Attention ! La suppression videra de manière irréversible la table des entités. Confirmez ?")) {
                    e.preventDefault();
                }
            });
        }
    }
};
document.addEventListener('DOMContentLoaded', deletePurge.ini);

var shareButtons = {
    ini: function() {
        var facebookShare = document.querySelector('#facebook_share');
        if(facebookShare) {
            facebookShare.addEventListener('click', function(e){
                e.preventDefault();
                var url = encodeURIComponent(document.location.href);
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank');
            });
        }

        var twitterShare = document.querySelector('#twitter_share');
        if(twitterShare) {
            twitterShare.addEventListener('click', function(e){
                e.preventDefault();
                var url = encodeURIComponent(document.location.href);
                window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + '&via=FloWebDevAPI' + "&url=" + url, '_blank');
            });
        }
    }
};
document.addEventListener('DOMContentLoaded', shareButtons.ini);