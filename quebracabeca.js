var rows = 3;
var columns = 3;

var currTile;  
var otherTile;

var turns = 0;

var imgOrder = ["4", "2", "8", "5", "1", "6", "7", "9", "3"];

window.onload = function() {
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

            document.getElementById("board").append(tile);
        }
    }
};

function dragStart() {
    currTile = this; 
}

function dragOver(e) {
    e.preventDefault();
}

function dragEnter(e) {
    e.preventDefault();
}

function dragLeave() {
    
}

function dragDrop() {
    otherTile = this; 
}

function dragEnd() {
    
    if (!otherTile.classList.contains("blank")) {
        return;
    }

   
    let [r1, c1] = currTile.id.split("-").map(Number);
    let [r2, c2] = otherTile.id.split("-").map(Number);

 
    let isAdjacent = (r1 === r2 && Math.abs(c1 - c2) === 1) || 
                     (c1 === c2 && Math.abs(r1 - r2) === 1);

    if (isAdjacent) {
   
        let currImgSrc = currTile.src;
        currTile.src = otherTile.src;
        otherTile.src = currImgSrc;

        currTile.classList.add("blank");
        otherTile.classList.remove("blank");

        turns += 1;
        document.getElementById("turns").innerText = turns;
    }
}
