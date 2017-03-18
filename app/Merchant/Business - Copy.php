<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$Business = new \Delight\Auth\Business($db);

$business_details;
$business_name;
$category1;
$category2;
$email;
$phone;
$mobile;
$contact_person;
$web;
$description;
if (isset($_GET)) {
		if (isset($_GET['id'])){
			foreach($Business->getBusinessById($_GET['id']) as $key => $value) {
				$business_name = $value['business_name'];
				$category1 = $value['category1'];
				$category2 = $value['category2'];
				$email = $value['business_email'];
				$phone = $value['business_phone'];
				$mobile = $value['business_mobile'];
				$contact_person = $value['contact_person'];
				$web = $value['website'];
				$description = $value['description'];
			}
		

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
  <div class="card-header">
   <div id="EditSection">
    Business Information: '.$business_name.'
	<div onclick="editonclick();" id="edit" class ="float-right" value="Edit"><u> Edit </u></div>
  </div>
  </div>
<form method="post" action ="Profile.php">
  <div class="card-block">
			<div class="form-group">
				<label for="business_name" class="form-label text-muted ">Business Name:</label>
					<input value="'.$business_name.'" type="hidden"  id="business_name_hidden"></input>
					<p class="form-control-static" type="text" value="'.$business_name.'" id="business_name"> '.$business_name.'</p>
			</div>
			
			<div class="form-group">
					<label for="category1" class="form-label text-muted">Main Category:</label>
					<input value="'.$category1.'" type="hidden"  id="category1_hidden"></input>
					<p class="form-control-static" type="text" value="'.$category1.'" id="category1"> '.$category1.'</p>
			</div>
			
			<div class="form-group">
					<label for="category2" class="form-label text-muted">Sub Category:</label>
					<input value="'.$category2.'" type="hidden"  id="category2_hidden"></input>
					<p class="form-control-static" type="text" value="'.$category2.'" id="category2"> '.$category2.'</p>
			</div>
			
			<div class="form-group">
					<label for="email" class="form-label text-muted">Email:</label>
					<input value="'.$email.'" type="hidden"  id="email_hidden"></input>
					<p class="form-control-static" type="text" value="'.$email.'" id="email"> '.$email.'</p>
			</div>
			
			<div class="form-group">
					<label for="phone" class="form-label text-muted">Phone:</label>
					<input value="'.$phone.'" type="hidden"  id="phone_hidden"></input>
					<p class="form-control-static" type="text" value="'.$phone.'" id="category1"> '.$phone.'</p>
			</div>
			
			<div class="form-group">
					<label for="mobile" class="form-label text-muted">Mobile:</label>
					<input value="'.$mobile.'" type="hidden"  id="mobile_hidden"></input>
					<p class="form-control-static" type="text" value="'.$mobile.'" id="category1"> '.$mobile.'</p>
			</div>
			
			<div class="form-group">
					<label for="contact_person" class="form-label text-muted">Contact Person:</label>
					<input value="'.$contact_person.'" type="hidden"  id="contact_person_hidden"></input>
					<p class="form-control-static" type="text" value="'.$contact_person.'" id="category1"> '.$contact_person.'</p>
			</div>
			
			<div class="form-group">
					<label for="web" class="form-label text-muted">Web Site:</label>
					<input value="'.$web.'" type="hidden"  id="web_hidden"></input>
					<p class="form-control-static" type="text" value="'.$web.'" id="category1"> '.$web.'</p>
			</div>
			
			<div class="form-group">
					<label for="description" class="form-label text-muted">Description:</label>
					<input value="'.$description.'" type="hidden"  id="description"></input>
					<p class="form-control-static" type="text" value="'.$description.'" id="category1"> '.$description.'</p>
			</div>
			<button type="submit" class="btn btn-primary float-right" id="editFormButton">Save</button>
	</form>
	
  </div>
</div>


</div>

';

echo $text;
}
			
}



?>
 <script src="../../js/jquery-3.1.1.slim.min.js"></script>
<script>

function HideButton() {
   $("#editFormButton").hide();
}

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
			$("#editFormButton").show();
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
			
			$("#editFormButton").hide();
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if(this.name == "value"){
							OldFieldVale = this.value;
						}
						
						if(this.name == "type" & (this.value == "hidden" || this.value == "submit")){
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