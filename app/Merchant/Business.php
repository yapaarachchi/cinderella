<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$text = '
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img src="images/7.png" alt="First slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
    <div class="carousel-item">
      <img src="images/5.jpg" alt="Second slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
    <div class="carousel-item">
      <img src="images/3.jpg" alt="Third slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

</br>';
$text = $text. '
<div id="mainarea">
<div class="card">
  <div id="EditSection" class="card-header">
    Business Information
	
	<div onclick="editonclick();" id="edit" class ="float-right" value="Edit"><u> Edit </u></div>
	
  </div>
</div>

<div class="row">

<div class="col-lg-6 col-sm-12">
<div class="card">
	<div class="card-block">
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Text:</label>
		<div class="col-10">
			<input value="Artisanal kale ddd ffff dsdd" type="hidden"  id="name_hidden"></input>
			<p class="form-control-static" type="text" value="Artisanal kale ddd ffff dsdd" id="name"> Artisanal kale ddd ffff dsdd ggg yyy</p>
	
		</div>
	</div>
	<div class="form-group row">
	  <label for="example-text-input" class="col-2 col-form-label">Text:</label>
		<div class="col-10">
			<input value="Artisanal kale" type="hidden"  id="name1_hidden"></input>
			<p class="form-control-static" type="text" value="Artisanal kale" id="name1"> Artisanal kale </p>
	
		</div>
	</div>
<div class="form-group row">
  <label for="example-search-input" class="col-2 col-form-label">Search</label>
  <div class="col-10">
    <input class="form-control" type="search" value="How do I shoot web" id="example-search-input"></input>
  </div>
</div>
<div class="form-group row">
</br>
  <label for="example-email-input" class="col-2 col-form-label">Email</label>
  <div class="col-10">
    <input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input"></input>
  </div>
</div>
	</div>
</div>

</div >


<div class="col-lg-6 col-sm-12">
<div class="card">
	<div class="card-block">
	
				<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Text</label>
  <div class="col-10">
    <input class="form-control" type="text" value="Artisanal kale" id="example-text-input"></input>
  </div>
</div>
<div id="myDiv" class="form-group row">
</br>
  <label for="example-search-input" class="col-2 col-form-label">Search</label>
  <div class="col-10">
    <input class="form-control" type="search" value="How do I shoot web" id="example-search-input"></input>
  </div>
</div>
<div class="form-group row">
  <label for="example-email-input" class="col-2 col-form-label">Email</label>
  <div class="col-10">
    <input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input"></input>
  </div>
</div>
	</div>
</div>

</div>

</div>

</div>


';

echo $text;
?>
 <script src="../../js/jquery-3.1.1.slim.min.js"></script>
<script>

function editonclick(){
	
	
	var attr;
	var TextVale;
	var OldVale;
	var OldFieldVale;
	var possible;
	
	$('#EditSection').find('div').each(function(){
			$(this).each(function() {
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						OldVale = this.value;
						if(this.name == "value" & OldVale == "Edit"){
							this.value= "CancelEdit"
							TextVale = "Cancel Edit";
						}
						
						if(this.name == "value" & OldVale == "CancelEdit"){
							this.value= "Edit"
							TextVale = "Edit";
						}
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';			
					}
				  });
				}); 
				$(this).replaceWith($('<div '+ attr +' > <u>' + TextVale + '</u></div>'));
		});
		
		if(OldVale == "Edit"){
			$('#mainarea').find('p').each(function(){
			
			
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if(this.name == "type" & this.value == "hidden"){
							possible = false;
							return false; 
						}
						else{
							possible = true;						
						}	
						
						if(this.name == "class" & this.value == "form-control-static"){
								this.value= "form-control"
							}
						
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';	
					}
				  });
				
				if(possible === true){
					$(this).replaceWith($('<input '+ attr +' >' + $(this).val() + '</input>'));
				}
		});
		}
		else if(OldVale == "CancelEdit"){
			$('#mainarea').find(':input').each(function(){
			
			
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if(this.name == "value"){
							OldFieldVale = this.value;
						}
						
						if(this.name == "type" & this.value == "hidden"){
							possible = false;
							return false; 
						}
						else{
							possible = true;						
						}	
						if(this.name == "class" & this.value == "form-control"){
							this.value= "form-control-static"
						}
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';			
					}
				  });
				
				if(possible === true){
					$(this).replaceWith($('<p '+ attr +' >' + OldFieldVale + '</p>'));
					OldFieldVale = "";
				}
		});
		}

	$("#mainarea").hide().fadeIn('fast');	
		
	}
	

</script>