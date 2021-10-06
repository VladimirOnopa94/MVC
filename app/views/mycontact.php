<h2>My Contact</h2>
<form id="mycontact_form" class="container-fluid">
	<div class="row">
		<label>
			Publish my contact
			<input type="checkbox" name="publish_contact">
		</label>
	</div>
	<div class="row">
		<div class="col-md-4 main_info">
			<span>Contact</span>
			<div>
				<label for="firstname_inp">Firstname</label>
				<input type="text" id="firstname_inp" name="firstname" placeholder="Firstname">
			</div>
			<div>	
				<label for="lastname_inp">Lastname</label>
				<input type="text" id="lastname_inp" name="lastname" placeholder="Lastname">
			</div>
			<div>
				<label for="address_inp">Address</label>
				<input type="text" id="address_inp" name="address" placeholder="Address">
			</div>
			<div>
				<label for="city_inp">Zip/City</label>
				<input type="text" id="city_inp" name="city" placeholder="City">
			</div>
			<div>
				<label for="country_select">Country</label>
				<select name="country" id="country_select">
					<option value="1">UK</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<span>Phones</span>
			<div class="phone_list_container">
				<div>
					<input type="text" name="phone[]">
					<input type="checkbox" name="phone[]">
				</div>
			</div>
			<span id="add_phone">Add</span>
		</div>
		<div class="col-md-4">
			<span>Emails</span>
			<div class="phone_list_container">
				<div>
					<input type="text" name="email[]">
					<input type="checkbox" name="email[]">
				</div>
			</div>
			<span id="add_email">Add</span>
		</div>
	</div>
	<button>Save</button>
</form>