<?php

namespace App\Controllers;

use App\Models\Book;
use JosueIsOffline\Framework\Controllers\AbstractController;
use JosueIsOffline\Framework\Database\DB;
use JosueIsOffline\Framework\Http\Response;

class BookController extends AbstractController
{
  public function show(int $id): Response
  {

    $book = new Book();


    var_dump($book->all());
    $books = DB::table("books")->select()->get();
    return $this->render("book.html.twig", [
      'id' => $id,
    ]);
  }

  public function create(): Response
  {
    return $this->render('create-book.html.twig');
  }
}
