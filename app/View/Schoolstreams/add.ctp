<?php
    echo $this->Form->create('Schoolstream');
?>
    <?php
    ?><fieldset class="sectiondefinition1"><legend class="sectiondefinition">New Stream Details</legend>
<table>
<tr class = "olevelresults">
  <td>
    <?php
      echo $this->Form->input('stream', array('label' => 'Stream Name'));
    ?>
  </td>
</tr>
<tr class = "olevelresults">
  <td>
    <?php
      echo $this->Form->input('shortstreamname', array('label' => 'Short Stream Name'));
    ?>
  </td>
</tr>
</table>
<?php
 echo $this->Form->end('Add Stream');
?>