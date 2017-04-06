<?php
echo "

<p> Profile Page</p>

";

?>

<link rel="stylesheet" href="../../css/dropzone.css">
<script type="text/javascript" src="../../js/dropzone.js"></script>


<form id="mydz" method="post" action="/upload" class="dropzone">
drop files here..
<div id="preview">

</div>
</form>



<script>
         Dropzone.options.mydz = {
            maxFiles: 1,
			uploadMultiple: false,
			autoProcessQueue:false,
			dictDefaultMessage: "",
			acceptedFiles: "image/*",
			dictMaxFilesExceeded: "error message by gayan",
			addRemoveLinks:true,
			dictCancelUploadConfirmation: "Cancel Upload",
			dictRemoveFile: "Delete"
            }
         
      </script>