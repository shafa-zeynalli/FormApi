<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        ul{
            /*display: flex;*/
            flex-direction: column;
        }
        li{
            background-color: #04a7a7;
            list-style-type: none;
            padding: 10px;
            margin: 10px auto;
            width: 60%;
        }
        li h2{
            text-align: center;
            color: #b4196c;
        }
        li p{
            color: indigo;
        }
        span{
            margin-left: 5px;
            color: #c00420;
            font-size: 18px;
        }
        div{
            text-align: center;
            margin: 200px auto;
        }
        div button{
            margin: 10px;
            background-color: grey;
            color: white;
            border: 3px solid #565454;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 12px;
        }
        div button:hover{
            background-color: #565454;
        }
    </style>
</head>
<body>

    <ul id="ul"></ul>
    <div id="pagination"></div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>

        const itemsPerPage = 10;
        let currentPage = 1;

        function loadData() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            let  ul = document.getElementById('ul')
            ul.innerHTML = "";

            $.ajax({
                url: 'https://jsonplaceholder.typicode.com/posts',
                method: 'GET',
                // data: data,
                success: (res) => {
                    let totalItems = res.length
                    res.sort((a, b) => b.id - a.id);
                    res.slice(startIndex, endIndex).map(d => {
                        let li = $(`<li>
                                        <h2>${d.title}</h2>
                                        <p>${d.body}</p>
                                        <p>Number <span>${d.id}</span> </p>
                                    </li>`);
                        li.click(()=>{commentData(d.id)})
                        $('ul').append(li);
                    })

                    $('div').html('');
                    // const paginationContainer = document.getElementById('pagination');

                    for (let i = 1; i <= Math.ceil(totalItems / itemsPerPage); i++) {
                        let  button = $(`<button>${i}</button>`);
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

        function commentData(id){
            let  div = document.getElementById('pagination')
            div.innerHTML = "";
            let  ul = document.getElementById('ul')
            ul.innerHTML = "";

            $.ajax({
                url: `https://jsonplaceholder.typicode.com/posts/${id}/comments`,
                method: 'GET',
                // data: data,
                success: (res) => {
                    res.map(d => {
                    console.log(d)

                        // if(id == d.postId) {
                            // console.log(d.title)
                            let p1 = document.createElement("p")
                            let p2 = document.createElement("p")
                            let p3 = document.createElement("p")
                            let span = document.createElement("span")
                            let li = document.createElement("li")
                            let h2 = document.createElement("h2")

                            h2.textContent = d.name;
                            p1.textContent = d.body;
                            span.textContent = d.email;
                            p2.textContent = 'Email: '
                            p3.textContent = `Id: ${d.id}`
                            p2.appendChild(span);
                            li.appendChild(h2);
                            li.appendChild(p1);
                            li.appendChild(p3);
                            li.appendChild(p2);
                            li.addEventListener('click', () => {
                            })
                            ul.appendChild(li);
                        // }
                    })
                }
            })
        }


        loadData();




    </script>
</body>
</html>


