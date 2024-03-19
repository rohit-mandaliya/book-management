<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1 class="text-center">Book Management</h1>
    <hr>

    <div class="container">
        <input class="form-control me-2" id="search" name="search" type="search" placeholder="Search"
            aria-label="Search">
        <button class="btn btn-outline-success" onclick="getBooks()">Search</button>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">Add Book</button>

            {{--  Add Book Modal --}}
            <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="addBookForm" method="post">
                                <label for="">Book Name</label>
                                <input type="text" name="name" placeholder="Book Name" class="form-control"
                                    required><br>
                                <label for="">Author Name</label>
                                <input type="text" name="author" placeholder="Author Name" class="form-control"
                                    required><br>
                                <label for="">Price</label>
                                <input type="text" name="price" placeholder="Enter Price" class="form-control"
                                    required><br>
                                <label for="">Genre</label>
                                <select name="genre" placeholder="" class="form-select" required>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Horror">Horror</option>
                                    <option value="History">History</option>
                                    <option value="Comedy">Comedy</option>
                                </select>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="addBookForm" class="btn btn-primary">Add Book</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- / Add Book Modal --}}

            {{--  Update Book Modal --}}
            <div class="modal fade" id="updateBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Book</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="updateBookForm" method="post">
                                <input type="hidden" name="bookId" id="bookId">
                                <label for="">Book Name</label>
                                <input type="text" name="name" id="name" placeholder="Book Name"
                                    class="form-control" required><br>
                                <label for="">Author Name</label>
                                <input type="text" name="author" id="author" placeholder="Author Name"
                                    class="form-control" required><br>
                                <label for="">Price</label>
                                <input type="text" name="price" id="price" placeholder="Enter Price"
                                    class="form-control" required><br>
                                <label for="">Genre</label>
                                <select name="genre" id="genre" placeholder="" class="form-select" required>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Horror">Horror</option>
                                    <option value="History">History</option>
                                    <option value="Comedy">Comedy</option>
                                </select>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="updateBookForm" class="btn btn-primary">Update Book</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- / Update Book Modal --}}
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Author Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="books_records"></tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        getBooks();
    });

    function getBooks() {

        $.ajax({
            data: {
                'search': $('#search').val()
            },
            url: "{{ route('books.index') }}",
            method: 'get',
            success: function(res) {
                let books = res.books;
                if (books.length < 1) {
                    $('.books_records').html(
                        '<tr><td class="text-center bg-danger text-white h5" colspan="6">No Records Found</td></tr>'
                    )
                } else {
                    let appendCode = "";
                    books.forEach(book => {
                        appendCode +=
                            `<tr>
                                    <td>${book.id}</td>
                                    <td>${book.name}</td>
                                    <td>${book.author}</td>
                                    <td>${book.price}</td>
                                    <td>${book.genre}</td>
                                    <td><button onClick="updateShowModal(${book.id})" class="btn btn-primary">Edit</button>
                                    <button onClick="deleteRecord(${book.id})" class="btn btn-danger">Delete</button></td>
                                </tr>`;
                    });

                    $('.books_records').html(appendCode);
                }
            }
        })
    }

    $('#addBookForm').submit(function(e) {
        e.preventDefault();
        let form = $(this).serialize();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: "{{ route('books.store') }}",
            method: 'POST',
            data: form,
            success: function(res) {
                alert(res);
                $('#addBookModal').modal('hide');
                $('#addBookForm').trigger('reset');
                getBooks();
            }
        });
    })


    function updateShowModal(bookId) {
        $.ajax({
            url: `{{ route('books.index') }}/${bookId}/edit`,
            method: 'GET',
            success: function(res) {
                let book = res.book;

                $('#name').val(book.name);
                $('#author').val(book.author);
                $('#price').val(book.price);
                $('#genre').val(book.genre);
                $('#bookId').val(bookId);

                $('#updateBookModal').modal('show');
            }
        })
    }

    function deleteRecord(bookId) {
        if (confirm('Are you sure you want to delete ?'))
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: `{{ route('books.index') }}/${bookId}`,
                method: 'delete',
                success: function(res) {
                    alert(res)
                    getBooks()
                }
            })
    }

    $('#updateBookForm').submit(function(e) {
        e.preventDefault();
        let bookId = $('#bookId').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            url: `{{ route('books.index') }}/${bookId}`,
            method: 'put',
            data: $(this).serialize(),
            success: function(res) {
                $('#updateBookModal').modal('hide');
                $('#updateBookForm').trigger('reset');
                getBooks();
                alert(res);
            }
        })
    })
</script>

</html>
