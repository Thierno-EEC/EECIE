<table>
    <tr>
        <th>Date</th>
        <th>Nom de l'issue</th>
        <th>Status</th>
    </tr>
    <?php 
    foreach($issues as $issue):
    ?>
    <tr>
        <td><?= $issue->last_update ?></td>
        <td><?= $issue->titre ?></td>
        <td><?= $issue->label->name ?></td>
    </tr>
    <?php 
    endforeach;
    ?>
</table>