<?php
if(isset($_SESSION["ycms_adm_user"]))
{ ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       movies
        <small>Manage the movie section</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Contenu</a></li>
        <li class="active">Movie</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Manage current movies</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table">
            <?php list_movie(); ?>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Il y a x movies disponible ainsi que x downloads
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

            <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add a movie</h3>

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
              <label for="movie_name">Nom de la vidéo*</label>
              <input type="text" class="form-control" name="movie_name" id="movie_name" placeholder="Mon movie">
            </div>     
            <div class="form-group">
               <label>Catégories *</label>
                <select name="movie_cat" class="form-control">
                <?php get_movie_cat(); ?>
                </select>
                </div>
                  <div class="form-group">
                  <label>Description *</label>
                 <div class="box-body pad">
                <textarea name="movie_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
            </div>
            </div>
            <div class="form-group">
                <label>Video publique ?</label>
            </div>
             <div class="form-group">
                <label>Oui 
                  <input type="radio" name="movie_public" class="flat-red" value="y" checked>
                </label>
                <label>Non 
                  <input type="radio" name="movie_public" class="flat-red" value="n">
                </label>
              </div>
              <div class="form-group">
                <label>Commentaires autorisés  ?</label>
            </div>
             <div class="form-group">
                <label>Oui 
                  <input type="radio" name="movie_a_comment" class="flat-red" value="y" checked>
                </label>
                <label>Non 
                  <input type="radio" name="movie_a_comment" class="flat-red" value="n">
                </label>
              </div>
                <div class="form-group">
                  <label for="movie_source_file">Sources file</label>
                  <input type="file" name="movie_source_file" id="movie_source_file">

                  <p class="help-block">Mp4 only</p>
                </div>
                <div class="form-group">
                  <label for="movie_source_file">Mots - Clés</label>
                  <input type="text" name="movie_keywords" id="movie_keywords">
                  <p class="help-block">Vous pouvez séparer les mots-clés à l'aide de ",".</p>
                </div>
                <div class="form-group">
                  <label for="movie_binary_win">Youtube</label>
                  <input type="text" name="movie_yt" id="movie_yt">

                  <p class="help-block">Youtube Id</p>
                <div class="col-xs-3 form-group">
                  <button type="submit" name="movie_add" class="btn btn-block btn-success btn-lg">Add a movie</button>
                </div>   
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        <?php
          if(isset($_POST["movie_add"])){ 
             $result = movie_add($_POST["movie_name"], $_POST["movie_cat"], $_POST["movie_description"], $_POST["movie_public"], $_POST["movie_a_comment"], $_FILES["movie_source_file"], $_POST["movie_yt"], get_display_name($_SESSION["ycms_adm_user"]), $_POST["movie_keywords"]);  
             if(!$result){
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
