<?php
$titleError = '';
$bodyError = '';

$title = $_GET['title'] ?? '';
$body = $_GET['body'] ?? '';

if (isset($_GET['action'])) {

    if ($title === '') {
        $titleError = 'Basliq hissesi bos buraxilmamalidi';
    }
    if ($body === '') {
        $bodyError = 'Metn hissesi bos buraxilmamalidi';
    }

    $errors = array(
        'title' => $titleError,
        'body' => $bodyError,
    );

    $resp = json_encode($errors);
    header('Content-Type: application/json; charset=utf-8');
    echo $resp;

    exit();
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        ul {
            display: flex;
            flex-direction: column;
        }

        li {
            background-color: #04a7a7;
            list-style-type: none;
            padding: 10px;
            margin: 10px auto;
            width: 60%;
        }

        li h2 {
            text-align: center;
            color: #b4196c;
        }

        li p {
            color: indigo;
        }

        li .p{
            width: auto;
            color: #0bda2d;
            float: right;
            display: flex;
        }
        span {
            margin-left: 5px;
            color: #c00420;
            font-size: 18px;
        }

        #pagination {
            text-align: center;
            margin: 200px auto;
            display: flex;
            width: 50%;
        }

        div button {
            margin: 10px;
            background-color: grey;
            color: white;
            border: 3px solid #565454;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 12px;
        }

        div button:hover {
            background-color: #565454;
        }

        form {
            display: flex;
            box-sizing: border-box;
            flex-direction: column;
            width: 50%;
            margin: 50px auto;
        }

        form p{
            font-size: 12px;
            color: red;
        }

        input {
            box-sizing: border-box;
            margin: 5px 0;
            padding: 5px;
            width: 100%;
            border: 1px solid green;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #04a7a7;
            border: none;
            color: white;
            font-size: 18px;
            box-sizing: border-box;
        }

        form button:hover {
            background-color: #047575;
            cursor: pointer;
        }

        li p i {
            color: white;
            font-size: 18px;
            margin: 0 5px;
        }
        #popup-overlay{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
            display: none;
        }
        #popup {
            position: fixed;
            top: -150%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            width: 450px;
            text-align: center;
            padding: 20px;
            z-index: 2;
        }

        .popup-close-btn{
            position: absolute;
            top: 20px;
            right: 20px;
            width: 30px;
            height: 30px;
            background-color: #222;
            color: #fff;
            font-size: 25px;
            font-weight: 600;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<form action="" method="get" id="myForm">
    <label for="title"> Basligi yazin:
        <input id="title" name="title">
    </label>
    <p id="errorTitle"></p>
    <label for="body">Metni yazin:
        <input id="body" name="body">
    </label>
    <p id="errorBody"></p>
    <button type="submit" id="btn">Elave Et</button>
</form>

<ul id="ul"></ul>
<div id="pagination"></div>

<div id="popup-overlay"></div>
<div id="popup">
    <form action="" method="get" id="myForm2">
        <label for="title2"> Basligi yazin:
            <input id="title2" name="title2">
        </label>
        <label for="body2">Metni yazin:
            <input id="body2" name="body2">
        </label>
        <button type="submit" id="btn2">Elave Et</button>
    </form>
    <div class="popup-close-btn">&times;</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>

    const itemsPerPage = 10;
    let currentPage = 1;


    function loadData() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        let ul = document.getElementById('ul')
        ul.innerHTML = "";

        $.ajax({
            url: 'https://formapi-caffc-default-rtdb.firebaseio.com/form.json',
            method: 'get',
            // data: newData,
            success: (res) => {
                let totalItems = res?.length;
                // res.sort((a, b) => b.id - a.id);

                for(let x in res) {

                    let li = $(`<li>
                                        <h2>${res[x].title}</h2>
                                        <p>${res[x].body}</p>
                                        <p>Number <span>${res[x].id}</span> </p>
                                        <p class="p">
                                              <span class="delete" data-id="${x}"><i  class="fa-solid fa-trash-can "></i></span>
                                              <span class="edit" data-id="${x}"> <i class="fa-solid fa-pen-to-square"></i></span>
                                        </p>
                                </li>`);

                    $(li).find('.delete').click(function () {
                        let id = $(this).data('id');
                        deleteData(id);
                        console.log(`ID'si ${id} olan data silindi`);
                    });
                    $(li).find('.edit').click(function () {
                        editData(x,res[x]);
                    });
                    $('ul').append(li);
                }

                $('#pagination').html('');


                for (let i = 1; i <= Math.ceil(totalItems / itemsPerPage); i++) {
                    let button = $(`<button>${i}</button>`);
                    button.click(() => {
                        currentPage = i;
                        loadData();
                    });
                    $('#pagination').append(button);
                }
            },
            error: (err) => {
                console.error('Datadan verilenler cekile bilmedi ' + err);
            }
        })
    }


    $('#myForm').on('submit', (e)=>{
        e.preventDefault();

        let data = $('#myForm').serialize();
        // console.log(data)
        $.ajax({
            url: 'formApi.php?action=save',
            method: 'GET',
            data: data,
            success: (res)=>{
                if(res.title){
                    $('#title').css('border', '1px solid red')
                    $('#errorTitle').html(res.title);
                }else{
                    $('#title').css('border', '1px solid green')
                    $('#errorTitle').html('');

                }

                if(res.body){
                    $('#body').css('border', '1px solid red')
                    $('#errorBody').html(res.body);
                }else{
                    $('#body').css('border', '1px solid green')
                    $('#errorBody').html('');
                }

                if(!res.body && !res.title){
                    addData();
                }

            }
        })
    })

    function addData() {
        const postData = {
            title: $('#title').val(),
            body: $('#body').val(),
        };
        // console.log(postData)
        $.ajax({
            url: 'https://formapi-caffc-default-rtdb.firebaseio.com/form.json',
            method: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: (data) => {
                $('#title').val('');
                $('#body').val('');
                loadData()
                // console.log(data)
            },
            error: (error) => {
                console.error('Yeni data elave etme xetasi: ' + error);
            }
        });
    }


    function deleteData(id) {

        $.ajax({
            url: `https://formapi-caffc-default-rtdb.firebaseio.com/form/${id}.json`,
            method: 'DELETE',
            contentType: 'application/json',
            success: (data) => {

                loadData()
                console.log(data)
            },
            error: (error) => {
               console.error('Yeni data elave etme xetasi: ' + error);
            }
        });
    }

    function editData(id, data){
        $('#popup').css('top','50%')
        $('#popup-overlay').css('display','block')

        $('#popup-overlay').click(function(){
            $(this).css('display','none')
            $('#popup').css('top','-150%')
        })
        $('.popup-close-btn').click(()=>{
            $('#popup').css('top','-150%')
            $('#popup-overlay').css('display','none')
        })

        $('#title2').val(data.title);
        $('#body2').val(data.body);

        $('#title2').on('input', function(e) {
            postData.title = e.target.value;
        });
        $('#body2').on('input', function(e) {
            postData.body = e.target.value;
        });
        const postData = {
            // title: $('#title2').change(function(){
            //     return $(this).val()
            // }),
            title: $('#title2').val(),
            body: $('#body2').val(),
        };

        console.log({
            title: $('#title2').val()
        })


        $('#btn2').click((e)=>{
            e.preventDefault();
            console.log(postData)
            console.log('hiuuhu')

            $.ajax({
                url: `https://formapi-caffc-default-rtdb.firebaseio.com/form/${id}.json`,
                method: 'PUT',
                data: JSON.stringify(postData),
                contentType: 'application/json',
                success: (data) => {
                    $('#title2').val('');
                    $('#body2').val('');
                    $('#popup-overlay').css('display','none');
                    $('#popup').css('top','-150%');
                    loadData()
                    console.log(data)
                },
                error: (error) => {
                    console.error('Yeni data elave etme xetasi: ' + error);
                }
            });
        })
    }

    loadData();

</script>
</body>
</html>


