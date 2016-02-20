
$(document).ready(function($) {
    $('.deleteCategory').click(function(e) {
        var label = $(this).data('id');

        e.preventDefault();
        if (window.confirm("Voulez vous vraiment supprimer la catégorie "+ label +" ,tout ses articles et ses commentaires ?")) {
            location.href = this.href;
           var href = $(this).attr("href");
        }
    });

    $('.deletePost').click(function(e) {
        var title = $(this).data('id');

        e.preventDefault();
        if (window.confirm("Voulez vous vraiment supprimer le post "+ title +" et ses commentaires ?")) {
            location.href = this.href;
           var href = $(this).attr("href");
        }
    });

    $('.deleteComment').click(function(e) {
        var title = $(this).data('id');

        e.preventDefault();
        if (window.confirm("Etes-vous sur de vouloir supprimer ce commentaire ?")) {
            location.href = this.href;
           var href = $(this).attr("href");
        }
    });

    $("#batchActions").submit(function(e) {
    
    // var val = $("input[type=submit][clicked=true]").val();
    var checkboxes = $("input:checked[type='checkbox'][name='toDelete[]']");
    if(checkboxes.length > 0)
    {
        var val = $(this).find("input[type=submit]:focus" );

        if(!confirm("Voulez vous vraiment "+ val.val()+" les éléments sélectionnés?")){
            e.preventDefault();
        }

    }
    else
        alert("Veullez sélectionner un article");
        
    // return false;
});
   
});
 function toggleToDelete(source) {
      var checkboxes = $("input[type='checkbox'][name='toDelete[]']");

      for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
      }
}

