<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$userdata = $this->session->userdata('UserData');
$UserData = json_decode($userdata);
?>


<section class="container-fluid advance-search">
  <div class="container result-container">
  	<div class="col-sm-3 result-left-col">
    	<h1>Busqueda Avanzada</h1>
        <ul>
        	<li><input type="radio" name="search_radio" value="ceos" rel="<?php echo $UserData[0]->id; ?>" checked="checked" /><p>CEO</p></li>
            <li><input type="radio" name="search_radio" value="proposals" rel="<?php echo $UserData[0]->id; ?>" /><p>Propuestas</p></li>
            <li><input type="radio" name="search_radio" value="businesses" rel="<?php echo $UserData[0]->id; ?>" /><p>Empresa</p></li>
            <li><input type="radio" name="search_radio" value="industries" rel="<?php echo $UserData[0]->id; ?>" /><p>Industrias</p></li>
        </ul>
    </div>
    <div class="col-sm-8 result-right-col">
    	<h1>ALL CEO's LIST</h1>
        <div class="ceo-result-row">
        	<h1>No Results!</h1>
        </div>
    </div>
  </div>
</section>