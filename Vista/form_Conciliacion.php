    
<div class="container">

<div id='btnEmpresas' align="center"></div></br></br>

    <input  type="text" class="input-xxlarge" id="txtEmpresa" name="empresa" readonly>
    
        <form enctype="multipart/form-data">
            <div class="form-group">
                <input id="fileToUpload" 
                name="fileToUpload" 
                type="file" 
                class="file" 
                multiple="true" 
                data-preview-file-type=""
                data-show-caption = "true"
                data-remove-label='Eliminar'
                data-upload-label='Subir'
                data-browse-label='Buscar &hellip;' 
                data-upload-url = "ajax_upload.php"
                data-upload-async="true" />                
            </div>
        </form>

</div>



<script type="text/javascript">
$(inicioActSPS());  

function inicioActSPS(){
    var idEmpresa=1;
    var nombreEmpresa="GIF SEGURIDAD";
    $("#txtEmpresa").val("Subir archivos para empresa "+nombreEmpresa);
}

    $('#fileToUpload').on('fileuploaded', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra,
    response = data.response, reader = data.reader;
    console.log('File uploaded triggered');
    alert (response.message);
    });
</script>