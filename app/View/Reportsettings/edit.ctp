<h1 class="sectiondefinition1">Report Print settings</h1>
<?php
  echo $this->Form->create('Reportsetting');
  echo $this->Session->flash('good');
  echo $this->Session->flash('bad');
?>
<fieldset class="sectiondefinition1">
  <legend class="sectiondefinition">Header Section</legend>
  <table>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('school_name', array('label' => 'School Name'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('school_address', array('label' => 'School Address'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('school_telephone_number', array('label' => 'School Telephone Number'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('o_level_report_header', array('label' => 'Ordinary Level Report Header name'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('a_level_report_header', array('label' => 'Advanced Level Report Header Name'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('o_level_show_inbuilt_header', array('label' => 'Show top header information for O-level report'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('a_level_show_inbuilt_header', array('label' => 'Show top header information for A-level report'));
        ?>
      </td>
    </tr>
  </table>
</fieldset>
<fieldset class="sectiondefinition1">
  <legend class="sectiondefinition">Comment Section</legend>
  <table>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('headteacher_name', array('label' => 'Headteacher\'s name'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('dorm_master_name', array('label' => 'Dorm master\'s name(Use the name of the Senior House master)'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('dorm_mistress_name', array('label' => 'Dorm mistress\'s name (Use the name of the Senior House mistress)'));
        ?>
      </td>
    </tr>
    <tr class = "olevelresults">
      <td>
        <?php
          echo $this->Form->input('school_motto', array('label' => 'School motto'));
        ?>
      </td>
    </tr>
  </table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Ordinary level report margin space print settings</legend>
    <table>
        <tr class = "olevelresults">
          <td>
            <?php
              echo $this->Form->input('o_level_top_space', array('label' => 'Ordinary Level Report Space from top of template'));
            ?>
          </td>
        </tr>
        <tr class = "olevelresults">
          <td>
            <?php
              echo $this->Form->input('o_level_left_space', array('label' => 'Ordinary Level Report Space from left of template'));
            ?>
          </td>
        </tr>
    </table>
</fieldset>
<fieldset class="sectiondefinition1"><legend class="sectiondefinition">Advanced level report margin space print settings</legend>
<table>
<tr class = "olevelresults">
  <td>
    <?php
	    echo $this->Form->input('a_level_top_space', array('label' => 'Advanced Level Report Space from top of template'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
	    echo $this->Form->input('a_level_left_space', array('label' => 'Advanced Level Report Space from left of template'));
    ?>
  </td>
</tr>
</table>
</fieldset>
<?php
 echo $this->Form->end('Edit Report Settings');
?>