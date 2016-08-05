<style type="text/css">
    .editor-toolbar.fullscreen{
        top: 70px;
        z-index: 12;
    }

    .editor-preview-side{
        top: 120px;
        z-index: 12;
    }

    .CodeMirror-fullscreen{
        top: 120px;   
        z-index: 11;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        var simplemde = new SimpleMDE({ element: document.getElementById("editor") });
    });
</script>
