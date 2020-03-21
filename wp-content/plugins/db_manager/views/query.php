<style>

.db_manager_textarea2 {
  margin: 10px;
  width: 50%;
  min-width: 300px;
  resize: both;
}

input.submit_ {
  display: block;
  margin: 0 10px;
}

</style>
<form>
  <textarea name="sql" cols="30" rows="10" class="db_manager_textarea2" required>
    <?= $sql ?>
  </textarea>
  <input type="hidden" name="page" value="db_manager">
  <input type="hidden" name="sub_page" value="query">
  <input class="submit_" type="submit" value="<?= $submit ?>">
</form>
<div>
  <?= $sub_content ?>
</div>