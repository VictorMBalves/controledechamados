<?php
    if(!isset($_GET['id_chamadoespera'])){
        return;
    }
    $id = $_GET['id_chamadoespera'];
?>
<div class="modal fade" id="modalAgenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agendamento chamado Nº<?php echo $id;?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" name="id" id="id" class="form-control" value="<?php echo $id; ?>" style="display:none;">
                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="data">Data:</label>  
                        <input type="date" name="data" id="data" class="form-control">
                    </div>
                    <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                        <label class="col-md-2 control-label" for="horario">Horario:</label>  
                        <input name="horario" id="horario" type="time" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="salvarAgendamento" type="button">Salvar</a>
            </div>
        </div>
    </div>
</div>
<script>
    $("#salvarAgendamento").click(function(){
        data = $("#data");
        horario = $("#horario");
        id = $("#id");
        i = 0;
        if(data.val() === ""){
            data.addClass("is-invalid");
            i++;
        }
        if(horario.val() === ""){
            horario.addClass("is-invalid");
            i++;
        }
        if(i != 0){
            notificationWarningOne("Preencha os campos obrigatórios!");
            return;
        }
        $(this).html('<img src="../imagem/ajax-loader.gif">');
        $(this).addClass(" disabled ");
        
            $.ajax({
            type: "POST",
            url: "../updates/updateconsulta.php",
            data:{id: id.val(),
                 dataagendamento:data.val()+" "+horario.val()},
            success: function(data)
            {
                data = data.trim();
                if(data == "success"){
                    $(this).html("Salvar");
                    notificationSuccess('Registro salvo', 'Agendamento salvo com sucesso!');
                    chamadoandamento();
                    chamadosatrasados();
                    chamadospendentes();
                    chamadoagendados();
                    setTimeout(function(){
                        $("#modalAgenda").modal('hide');
                    }, 1000);
                }else{
                    $(this).html("Salvar");
                    $(this).removeClass(" disabled ");
                    notificationError('Ocorreu um erro ao salvar o registro: ', data);
                }
            }
        });
    })
</script>