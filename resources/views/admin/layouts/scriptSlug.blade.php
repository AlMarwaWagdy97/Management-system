<script>
    $(document).ready(function(){
        $("#title"+ {{ $key }}).on('keyup', function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g,'-');
            $("#slug"+{{ $key }}).val(Text);
        });

    });
    $(document).ready(function(){
        $("#slug"+ {{ $key }}).on('keyup', function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g,'-');
            $("#slug"+{{ $key }}).val(Text);
        });

    });
</script>