<?php
if(isset($_SESSION["ycms_adm_user"]))
{ ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Scripts
        <small>Manage the script section</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Contenu</a></li>
        <li class="active">Script</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Manage current scripts</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table">
            <?php list_script(); ?>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Il y a x scripts disponible ainsi que x downloads
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

            <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add a script</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form method="post" enctype="multipart/form-data" action="">
            <div class="form-group">
              <label for="script_name">Nom du script *</label>
              <input type="text" class="form-control" name="script_name" id="script_name" placeholder="Mon script">
            </div>     
            <div class="form-group">
               <label>Catégories *</label>
                <select name="script_cat" class="form-control">
                  <option value="C">C</option>
                  <option value="C++">C++</option>
                  <option value="PHP">PHP</option>
                  <option value="C#">C#</option>
                  <option value="HTML/CSS">HTML/CSS</option>
                  <option value="Ruby">Ruby</option>
                </select>
                </div>
                  <div class="form-group">
                  <label>Description *</label>
                 <div class="box-body pad">
                <textarea name="script_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            </div>
            <div class="form-group">
                <label>Source publique ?</label>
            </div>
             <div class="form-group">
                <label>Oui 
                  <input type="radio" name="script_source" class="flat-red" value="y" checked>
                </label>
                <label>Non 
                  <input type="radio" name="script_source" class="flat-red" value="n">
                </label>
              </div>
                <div class="form-group">
                  <label for="script_source_file">Sources file</label>
                  <input type="file" name="script_source_file" id="script_source_file">

                  <p class="help-block">Only zip format allowed. Max 10 Mo.</p>
                </div>
                <div class="form-group">
                  <label for="script_binary_win">Binaries</label>
                  <input type="file" name="script_binary_win" id="script_binary_win">

                  <p class="help-block">Windows.</p>

                  <input type="file" name="script_binary_lin" id="script_binary_lin">

                  <p class="help-block">Linux.</p>
                </div> 
                <div class="col-xs-3 form-group">
                  <button type="submit" name="script_add" class="btn btn-block btn-success btn-lg">Add a script</button>
                </div>   
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        <?php
          if(isset($_POST["script_add"])){ 
             $result = add_script($_POST["script_name"], $_POST["script_cat"], $_POST["script_description"], $_POST["script_source"], $_FILES["script_source_file"], $_FILES["script_binary_win"], $_FILES["script_binary_lin"], get_display_name($_SESSION["ycms_adm_user"]));  
             if(!($result == 42)){
             ?>

          <div class="alert alert-warning alert-dismissible">
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h4><i class="icon fa fa-warning"></i> Something is wrong !</h4>
              <?php 
                echo $result;
               }
          else{?>
          <div class="alert alert-success alert-dismissible">
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
             <h4><i class="icon fa fa-success"></i> Successfully uploaded</h4>
             <?php }} ?> 
          </div> 
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php } ?>
