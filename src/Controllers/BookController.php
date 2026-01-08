<?php

namespace App\Controllers;

use App\Models\Book;
use App\Helpers\Validator;

class BookController
{
    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new Book();
    }

    public function index()
    {
        $books = $this->bookModel->getAllBooks();
        require_once '../public/books/index.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $published_date = $_POST['published_date'];

            $validation = Validator::validateBook($title, $author, $isbn, $published_date);

            if ($validation['success']) {
                $this->bookModel->addBook($title, $author, $isbn, $published_date);
                header('Location: /books/index.php');
            } else {
                $errors = $validation['errors'];
            }
        }

        require_once '../public/books/add.php';
    }

    public function edit($id)
    {
        $book = $this->bookModel->getBookById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $published_date = $_POST['published_date'];

            $validation = Validator::validateBook($title, $author, $isbn, $published_date);

            if ($validation['success']) {
                $this->bookModel->updateBook($id, $title, $author, $isbn, $published_date);
                header('Location: /books/index.php');
            } else {
                $errors = $validation['errors'];
            }
        }

        require_once '../public/books/edit.php';
    }

    public function delete($id)
    {
        $this->bookModel->deleteBook($id);
        header('Location: /books/index.php');
    }

    public function view($id)
    {
        $book = $this->bookModel->getBookById($id);
        require_once '../public/books/view.php';
    }
}