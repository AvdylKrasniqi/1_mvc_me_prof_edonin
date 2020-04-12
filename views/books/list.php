<?php view('part/header') ?>

My books

<table>
  <thead>
    <tr>
      <th>Emri</th>
      <th>Autori</th>
      <th>Veprimet</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($books ?? [] as $book): ?>
      <tr>
        <td><?= $book['name'] ?></td>
        <td><?= $book['author'] ?></td>
        <td>
          <a href="/books/book.php?id=<?= $book['book_id'] ?>">Shfaq</a>
          <a href="/books/edit.php?id=<?= $book['book_id'] ?>">Edit</a>
          <form action="/books/book.php" method='post'>
            <input type='hidden' name='@method' value='delete' />
            <a href='/books/index.php' onclick="this.closest('form').submit(); return false;" >
              Delete
            </a>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="/books/new.php">Shto liber te ri</a>

<?php view('part/footer') ?>
