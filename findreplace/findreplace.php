<?php

class findreplace extends Module
{
	public function __construct()
	{
		$this->name = 'findreplace';
		$this->tab = 'administration';
		$this->version = '1.0';
	
        parent::__construct();
		$this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('Find Replace');
        $this->description = $this->l('Easily find and replace product text');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
	}

	public function getContent()
	{
		$output .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" style="clear: both;">
		<fieldset>
			<legend><img src="../img/admin/contact.gif" />'.$this->l('Find and Replace').'</legend>';
		if (Tools::isSubmit('submitReplace'))
		{
			$output .= '<h2>Find and replace completed</h2>';

			$table = "";
			$field = "";
			switch(Tools::getValue('location')) {
				case "product_name":
					$table = "product_lang";
					$field = "name";
					break;
				case "product_description":
					$table = "product_lang";
					$field = "description";
					break;
				case "product_description_short":
					$table = "product_lang";
					$field = "description_short";
					break;
				case "category_name":
					$table = "category_lang";
					$field = "name";
					break;
				case "category_description":
					$table = "category_lang";
					$field = "description";
					break;
			}


			Db::getInstance()->execute('UPDATE `'._DB_PREFIX_. $table .'` 
				SET `'. $field .'` = replace(`'. $field .'`,"'. Tools::getValue('find') .'","'. Tools::getValue('replace') .'")'); 
			$output .= '<p>"' . Tools::getValue('find') . '" was replaced with "' . Tools::getValue('replace') . '" on field "' .   Tools::getValue('location') .'"</p>';
		}
		
		$output .= '<label>'.$this->l('Find this:').'</label>
			<div class="margin-form"><input type="text" name="find" value="" style="width: 250px;" /></div>

			<label>'.$this->l('Replace with:').'</label>
			<div class="margin-form"><input type="text" name="replace" value="" style="width: 250px;" /></div>

			<label>'.$this->l('Field:').'</label>
			<div class="margin-form">

			<select type="text" name="location" value="" style="width: 250px;" />
				<option value="product_name">Product Name</option>
				<option value="product_description">Product Description</option>
				<option value="product_description_short">Product Description Short</option>

				<option value="category_name">Category Name</option>
				<option value="category_description">Category Description</option>
			</select>

			</div>
			
			<div class="clear center">
			<p>Find text is case sensitive.</p>
			<h2>Warning! This is irreversible! Use wisely</h2>
				<input type="submit" style="margin-top:20px" name="submitReplace" id="submitReplace" value="'.$this->l('   Replace   ').'" class="button" />
			</div>
			</fieldset>
			</form>
			';

			return $output;
	}

}