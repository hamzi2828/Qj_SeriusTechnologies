<ul class="nav nav-tabs">
    <li class="<?php echo $this -> input -> get ( 'tab' ) === 'general-information' ? 'active' : '' ?>">
        <a href="<?php echo base_url ( '/medical-tests/edit/' . $test -> id . '?tab=general-information' ) ?>">
            General Information
        </a>
    </li>
    
    <li class="<?php echo $this -> input -> get ( 'tab' ) === 'history' ? 'active' : '' ?>">
        <a href="<?php echo base_url ( '/medical-tests/edit/' . $test -> id . '?tab=history' ) ?>">History</a>
    </li>
    
    <li class="<?php echo $this -> input -> get ( 'tab' ) === 'general-physical-examination' ? 'active' : '' ?>">
        <a href="<?php echo base_url ( '/medical-tests/edit/' . $test -> id . '?tab=general-physical-examination' ) ?>">
            General Physical Examination
        </a>
    </li>
    
    <li class="<?php echo $this -> input -> get ( 'tab' ) === 'lab-investigation' ? 'active' : '' ?>">
        <a href="<?php echo base_url ( '/medical-tests/edit/' . $test -> id . '?tab=lab-investigation' ) ?>">
            Lab Investigations
        </a>
    </li>
</ul>