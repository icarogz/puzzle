<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quebra-Cabeça</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            color: #ffffff;
            background-color: rgb(5, 0, 78);
        }

        body .points {
            color: rgb(116, 224, 88);
        }

        #title {
            height: 190px;
            width: 190px;
            transition: transform 0.3s ease;
            animation: float 3s ease-in-out infinite;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
            border-radius: 15px;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        #board {
            width: 360px;
            height: 360px;
            background-color: rgb(174, 173, 230);
            border: 10px solid #0c67ae;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
        }

        #board img {
            width: 118px;
            height: 118px;
            border: 1px solid #0c67ae;
        }
    </style>
</head>

<body>
    <img id="title" src="./iconejogo.png" alt="Ícone do Jogo">
    <div id="board"></div>
    <h1>Jogadas: <span id="turns">0</span></h1>
    <div class="points"><h1>Pontuação: <span id="score">0</span></h1></div>

    <script>
        var rows = 3;
        var columns = 3;

        var currTile;
        var otherTile;

        var turns = 0;
        var score = 0;

        var imgOrder = ["4", "2", "8", "5", "1", "6", "7", "9", "3"];
        var correctOrder = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];

        window.onload = function () {
            initializeBoard();
        };

        function initializeBoard() {
            let board = document.getElementById("board");
            board.innerHTML = "";
            turns = 0;
            score = 0;
            document.getElementById("turns").innerText = turns;
            document.getElementById("score").innerText = score;

            imgOrder = shuffleArray([...correctOrder]);

            for (let r = 0; r < rows; r++) {
                for (let c = 0; c < columns; c++) {
                    let tile = document.createElement("img");
                    tile.id = `${r}-${c}`;
                    let imgNum = imgOrder.shift();
                    tile.src = `${imgNum}.jpg`;

                    if (imgNum === "9") {
                        tile.classList.add("blank");
                    }

                    tile.addEventListener("dragstart", dragStart);
                    tile.addEventListener("dragover", dragOver);
                    tile.addEventListener("dragenter", dragEnter);
                    tile.addEventListener("dragleave", dragLeave);
                    tile.addEventListener("drop", dragDrop);
                    tile.addEventListener("dragend", dragEnd);

                    board.append(tile);
                }
            }
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function dragStart() {
            currTile = this;
        }

        function dragOver(e) {
            e.preventDefault();
        }

        function dragEnter(e) {
            e.preventDefault();
        }

        function dragLeave() {}

        function dragDrop() {
            otherTile = this;
        }

        function dragEnd() {
            if (!otherTile || currTile === otherTile) {
                return;
            }

            let currImgSrc = currTile.src;
            currTile.src = otherTile.src;
            otherTile.src = currImgSrc;

            currTile.classList.toggle("blank");
            otherTile.classList.toggle("blank");

            turns += 1;
            document.getElementById("turns").innerText = turns;

            updateScore();
            checkWin();
        }

        function updateScore() {
            let tiles = document.querySelectorAll("#board img");
            let currentScore = 0;

            tiles.forEach((tile, index) => {
                let imgNum = tile.src.match(/(\d+)\.jpg/)[1];
                if (imgNum === correctOrder[index]) {
                    currentScore++;
                }
            });

            score = currentScore;
            document.getElementById("score").innerText = score;
        }

        function checkWin() {
            let tiles = document.querySelectorAll("#board img");
            let currentOrder = Array.from(tiles).map(tile => tile.src.match(/(\d+)\.jpg/)[1]);

            if (JSON.stringify(currentOrder) === JSON.stringify(correctOrder)) {
                setTimeout(() => {
                    alert("Parabéns! Você completou o quebra-cabeça!");
                    initializeBoard();
                }, 200);
            }
        }
    </script>
</body>
</html>
