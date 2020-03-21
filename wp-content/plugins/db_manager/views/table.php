<style>
.db_manager_table {
  padding-right: 20px;
  width: max-content;
  border-spacing: 8px;
}

.db_manager_table td,
.db_manager_table th
{
  border-bottom: #a0a0a0 1px solid;
  border-right: #a0a0a0 1px solid;
  border-radius: 2px;
  padding: 1px 4px;
  cursor: pointer;
}

.db_manager_table td {
  position: relative;
}

.db_manager_textarea {
  position: absolute;
  left: 0px;
  top: 0px;
  height: 200px;
  width: 200px;
  margin-top: 0px;
  margin-bottom: 0px;
  z-index: 100;
  resize: both;
}

.db_manager_table td:hover {
  box-shadow: 1px 1px 1px grey;
}

</style>

<table class="db_manager_table">
  <thead>
    <tr>
      <? foreach ($header as $h): ?>
        <th><?= $h ?></th>
      <? endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <? foreach ($data as $row): ?>
      <tr>
        <? foreach ($row as $el): ?>
          <td 
            <?= isset($el['raw']) ? ' data-raw="' . $el['raw'] . '"' : '' ?>
            <?= isset($el['id']) ? ' data-id="' . $el['id'] . '"' : '' ?>
            <?= isset($el['field_id']) ? ' data-field_id="' . $el['field_id'] . '"' : '' ?>
            <?= isset($el['field']) ? ' data-field="' . $el['field'] . '"' : '' ?>
          >
            <?= 
              isset($el['link']) ? 
              '<a href="' . $url . $el['link'] . '">' : 
              '' 
            ?><?= $el['value'] ?><?= 
              isset($el['link']) ? 
              '</a>' : 
              '' 
            ?>
          </td>
        <? endforeach; ?>
      </tr>
    <? endforeach; ?>
  </tbody>
</table>

<script>
(function($){
  $(document).mouseup(function (e) {
    var container = $(".db_manager_textarea");
    if (container.length == 0) return
    if (container.has(e.target).length === 0){
      if ($(e.target).hasClass('db_manager_textarea')) return
      if (container.val() != $(".db_manager_textarea").parent().attr('data-raw')) {
        $parent = container.parent()
        $.ajax({
          url: ajaxurl,
          method: 'POST',
          data: {
            'action': 'db_manager',
            'method': 'update',
            'id': $parent.attr('data-id'),
            'field_id': $parent.attr('data-field_id'),
            'field': $parent.attr('data-field'),
            'value': container.val(),
            'table': '<?= $table ?>'
          },
          success(data) {
            data = JSON.parse(data)
            if (data.success) {
              $parent.html(data.success.new_value)
            } else {

            }
          }
        })
      }
      container.remove()
    }
  });

  $('.db_manager_table').click(function(e) {
    var $el = $(e.target)
    var raw = $el.attr('data-raw')
    if (typeof raw !== typeof undefined && raw !== false) {
      $ta = $('<textarea class="db_manager_textarea">' + raw + '</textarea>')
      $el.append($ta)
    }
  })
})(jQuery)
</script>