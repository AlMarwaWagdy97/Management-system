

<html xmlns='http://www.w3.org/1999/xhtml'>
    <head></head>
    <body>
        <div style="position:fixed; top:40%;right:50%;text-align: center;font-weight: bold;color: yellowgreen;" >
            <img src="' . {{ site_path('img') }} . '/icon.gif"/>
            <p>   سيتم التحقيق من البينات </p>
        </div>';
        <form action='{{ $redirectUrl }}' method='post' name='frm'>\n";
            @foreach ($parameters as $a => $b) 
                    <input type='hidden' name='"{{ htmlentities($a) }}"' value='"{{ htmlentities($b) }}"'>\n";
            @endforeach
            <script type='text/javascript'>;
                document.frm.submit();
            </script>
        </form>
    </body>
</html>"