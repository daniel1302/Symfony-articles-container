jQuery(document).ready(function() {
    jQuery('table[rel="datatables"]').addClass('table table-striped table-bordered').DataTable();
    jQuery('[rel="markitup-markdown"]').markItUp(myMarkdownSettings);
});