let right = document.querySelectorAll('.right');
let left = document.querySelectorAll('.left');
let carousel = document.querySelectorAll('.carousel-inner');


for(let i = 0; i < right.length; i ++) {
            let newka1 = carousel[i].querySelector('.active').nextElementSibling;
            let srcnew1 = newka1.querySelector('img');
            let dataat1 = srcnew1.dataset.lazyLoadSrc;
            srcnew1.src = dataat1;


            right[i].addEventListener('click', function() {
                let newka = carousel[i].querySelector('.active').nextElementSibling.nextElementSibling;
                let srcnew = newka.querySelector('img');
                let dataat = srcnew.dataset.lazyLoadSrc;

                srcnew.src = dataat;

            })

    let itemCount = carousel[i].querySelectorAll('.item');
    let itemCountLast = itemCount[itemCount.length - 1];
    let itemCountImg = itemCountLast.querySelector('img');
    let itemCountData = itemCountImg.dataset.lazyLoadSrc;
    itemCountImg.src = itemCountData;

    left[i].addEventListener('click', function() {


        let newkaleft = carousel[i].querySelector('.active').previousElementSibling;
        let srcnewleft = newkaleft.querySelector('img');
        let dataatleft = srcnewleft.dataset.lazyLoadSrc;

        srcnewleft.src = dataatleft;

    })


}

