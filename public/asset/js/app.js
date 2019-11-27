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
                if (!confirm("Attention ! La confirmation de la suppression videra de manière irréversible la table des entités. Confirmez ?")) {
                    e.preventDefault();
                }
            });
        }
    }
};
document.addEventListener('DOMContentLoaded', deletePurge.ini);