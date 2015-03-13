<h1>Хорооллууд</h1>

<?php echo link_to('Шинээр үүсгэх', 'district/new')?>

<table class="list">
  <thead>
    <tr>
      <th>Нэр</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($districts as $district): ?>
    <tr>
      <td><?php echo link_to($district->getName(), 'district/edit?id='.$district->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

