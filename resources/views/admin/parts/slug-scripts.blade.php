<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script>
    $('#InputTitle').on('blur',function(){

    var theTitle=this.value.toLowerCase().trim(),
        slugInput=$('#InputSlug'),
        theSlug=theTitle.replace(/&/g,'-and-')
            .replace(/[^a-z0-9-]+/g,'-')
            .replace(/\-\-+/g,'-')
            .replace(/^-+|-+$/g,'');

    slugInput.val(theSlug);
    });
</script>