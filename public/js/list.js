$(document).ready(function($) {
    $('.delete').click(function(e) {
        var label = $(this).data('id');

        e.preventDefault();
        if (window.confirm("Voulez vous vraiment supprimer la catégorie "+ label +" ,tout ses articles et ses commentaires")) {
            location.href = this.href;
           var href = $(this).attr("href");
        }
    });
});
