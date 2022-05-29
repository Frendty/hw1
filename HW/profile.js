// Fetch commenti
function onJsonComments(json)
{
    let postDiv;
    //console.log(json);

    for(let commentNum in json)
    {
        postDiv = document.querySelector("section .post[data-post-id='" + json[commentNum].postId + "']");

        //console.log(postDiv);
        //console.log("Comment Num: " + commentNum);
        //console.log("Length: " + json.length);

        const commentDiv = document.createElement("div");
        commentDiv.classList.add("comment-box");
        commentDiv.classList.add("hidden");

        postDiv.appendChild(commentDiv);

        const headCommentDiv = document.createElement("div");
        headCommentDiv.classList.add("head");

        commentDiv.appendChild(headCommentDiv);

        const infoCommentDiv = document.createElement("div");
        infoCommentDiv.classList.add("info");

        headCommentDiv.appendChild(infoCommentDiv);

        const wrap_avatarCommentDiv = document.createElement("div");
        wrap_avatarCommentDiv.classList.add("wrap-avatar");

        infoCommentDiv.appendChild(wrap_avatarCommentDiv);

        const aWrap_avatarComment = document.createElement("a");
        aWrap_avatarComment.href = "#"; // Link profilo utente
        wrap_avatarCommentDiv.appendChild(aWrap_avatarComment);
        
        const imgAvatarComment = document.createElement("i");
        imgAvatarComment.classList.add("avatar");
        
        if(json[commentNum].avatar == "unset")
        {
            imgAvatarComment.classList.add("fa-solid");
            imgAvatarComment.classList.add("fa-circle-user");
        }

        aWrap_avatarComment.appendChild(imgAvatarComment);

        const divNameTimeComment = document.createElement("div");
        
        infoCommentDiv.appendChild(divNameTimeComment);
        
        const aNameComment = document.createElement("a");
        aNameComment.href = "#"; // Link profilo utente

        divNameTimeComment.appendChild(aNameComment);
        
        const nameCommentSpan = document.createElement("span");
        nameCommentSpan.classList.add("name");
        nameCommentSpan.textContent = json[commentNum].username;

        aNameComment.appendChild(nameCommentSpan);

        const pTimeComment = document.createElement("p");
        pTimeComment.classList.add("time");
        pTimeComment.textContent = json[commentNum].timeElapsed;

        divNameTimeComment.appendChild(pTimeComment);

        const pBodyComment = document.createElement("p");

        pBodyComment.textContent = json[commentNum].content;

        commentDiv.appendChild(pBodyComment);
    }
}

function onResponse(response)
{
    return response.json();
}

function fetchComments(postId)
{
    //console.log("AAAAA" + postId);

    fetch("http://localhost/HW/fetchLoadComments.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify({
                post: postId
            })
        }).then(onResponse).then(onJsonComments);
}

// Fetch posts
function onJson(json)
{
    //console.log(json);

    for(let postNum in json)
    {
        // console.log(json[postNum]);
        const sectionDiv = document.querySelector("section");

        const postDiv = document.createElement("div");
        postDiv.classList.add("post");

        postDiv.dataset.postId = json[postNum].postId;

        const headDiv = document.createElement("div");
        headDiv.classList.add("head");

        postDiv.appendChild(headDiv);
        
        const infoDiv = document.createElement("div");
        infoDiv.classList.add("info");

        headDiv.appendChild(infoDiv);

        const wrapAvatarDiv = document.createElement("div");
        wrapAvatarDiv.classList.add("wrap-avatar");

        infoDiv.appendChild(wrapAvatarDiv);

        const aAvatar = document.createElement("a");
        aAvatar.href = "#";

        wrapAvatarDiv.appendChild(aAvatar);

        let imgAvatar;
        if(json[postNum].avatar == "unset")
        {
            imgAvatar = document.createElement("i");
            imgAvatar.classList.add("fa-solid");
            imgAvatar.classList.add("fa-circle-user");
        }
        else
        {
            imgAvatar = document.createElement("img");
            imgAvatar.src = ""; // Settare immagine di profilo nel post
        }

        imgAvatar.classList.add("avatar");

        aAvatar.appendChild(imgAvatar);

        const divNameTime = document.createElement("div");

        infoDiv.appendChild(divNameTime);

        const aName = document.createElement("a");
        aName.href = "#";

        divNameTime.appendChild(aName);

        const name = document.createElement("span");
        name.classList.add("name");
        name.textContent = json[postNum].username;

        aName.appendChild(name);

        const pTime = document.createElement("p");
        pTime.classList.add("time");
        pTime.textContent = json[postNum].timeElapsed;

        divNameTime.appendChild(pTime);

        const bodyDesc = document.createElement("div");
        bodyDesc.classList.add("desc");
        bodyDesc.textContent = json[postNum].description;

        postDiv.appendChild(bodyDesc);

        const bodyImg = document.createElement("img");
        bodyImg.src = json[postNum].url_image;

        postDiv.appendChild(bodyImg);

        const footerDiv = document.createElement("div");
        footerDiv.classList.add("footer");

        postDiv.appendChild(footerDiv);

        const popInfoLike = document.createElement("span");
        popInfoLike.classList.add("popInfo");

        footerDiv.appendChild(popInfoLike);

        const heartI = document.createElement("i");
        heartI.classList.add("fa-regular");
        heartI.classList.add("fa-heart");

        if(json[postNum].liked)
        {
            heartI.classList.remove("fa-regular");
            heartI.classList.add("fa-solid");
            heartI.classList.add("red");
        }

        popInfoLike.appendChild(heartI);

        heartI.addEventListener("click", changeLike);           // Associo eventListener pulsante "like"

        const popInfoNLikes = document.createElement("span");
        popInfoNLikes.classList.add("popText");

        popInfoNLikes.textContent = json[postNum].nlikes;

        popInfoLike.appendChild(popInfoNLikes);

        const popInfoComment = document.createElement("span");
        popInfoComment.classList.add("popInfo");

        footerDiv.appendChild(popInfoComment);

        const commentI = document.createElement("i");
        commentI.classList.add("fa-regular");
        commentI.classList.add("fa-comment");
        commentI.dataset.show = "0";

        popInfoComment.appendChild(commentI);

        commentI.addEventListener("click", showHideComments);   // Associo eventListener pulsante "commento"

        const popInfoNComments = document.createElement("span");
        popInfoNComments.classList.add("popText");

        popInfoNComments.textContent = json[postNum].ncomments;

        popInfoComment.appendChild(popInfoNComments);

        const newCommentDiv = document.createElement("div");
        newCommentDiv.classList.add("newComment");
        newCommentDiv.classList.add("hidden");

        postDiv.appendChild(newCommentDiv);

        const inputNewComment = document.createElement("input");
        inputNewComment.type = "text";
        inputNewComment.placeholder = "Aggiungi un nuovo commento...";

        inputNewComment.addEventListener('keyup', addComment);  // Associo eventListener nuovo commento

        newCommentDiv.appendChild(inputNewComment);

        // Aggiunta sezione commenti
        // Fetch commenti attuali

        fetchComments(postDiv.dataset.postId);

        sectionDiv.appendChild(postDiv);
    }
}

function fetchPosts() {
    fetch("http://localhost/HW/fetch_personal_posts.php?user=" + encodeURIComponent(window.sessionStorage.getItem("user"))).then(onResponse).then(onJson);
}

document.addEventListener('DOMContentLoaded', fetchPosts);

// Handler per cambiare stile a icone dei like
function changeLike(e)
{
    const likeEl = e.currentTarget;
    const postId = likeEl.closest(".post").dataset.postId;
    const popText = likeEl.parentNode.querySelector(".popText");

    if(likeEl.classList.contains("fa-regular"))
    {
        likeEl.classList.remove("fa-regular");
        likeEl.classList.add("fa-solid");
        likeEl.classList.add("red");

        fetch("likePost.php?post=" + encodeURIComponent(postId));
        popText.textContent = parseInt(popText.textContent) + 1;
    }
    else
    {
        likeEl.classList.remove("fa-solid");
        likeEl.classList.add("fa-regular");
        likeEl.classList.remove("red");

        fetch("removeLike.php?post=" + encodeURIComponent(postId));
        popText.textContent = parseInt(popText.textContent) - 1;
    }
}

function showHideComments(e)
{
    const commentEl = e.currentTarget;
    const commentBoxes = commentEl.parentNode.parentNode.parentNode.querySelectorAll(".comment-box");
    const footer = commentEl.parentNode.parentNode;
    const newCommentBox = commentEl.parentNode.parentNode.parentNode.querySelector(".newComment");


    if(commentEl.dataset.show == 0)
    {
        commentEl.dataset.show = 1;
        for(let commentBox of commentBoxes)
        {
            commentBox.classList.remove("hidden");
        }
        newCommentBox.classList.remove("hidden");
        footer.classList.add("margin-footer-post");
    }
    else
    {
        commentEl.dataset.show = 0;
        for(let commentBox of commentBoxes)
        {
            commentBox.classList.add("hidden");
        }
        newCommentBox.classList.add("hidden");
        footer.classList.remove("margin-footer-post");
    }
}

// Nuovo commento

function onJsonNewComment(json)
{
    fetchComments(json.postId);
}

function addComment(e)
{
    if(e.code == "Enter")
    {
        if(e.currentTarget.value.trim().length > 0)
        {
            //console.log("Ci provo!");
            let currentComments = e.currentTarget.parentNode.parentNode.querySelectorAll(".comment-box");

            const postId = e.currentTarget.parentNode.parentNode.dataset.postId;

            const popText = e.currentTarget.parentNode.parentNode.querySelectorAll(".popInfo .popText");
            //console.log(popText[1]);
            popText[1].textContent = parseInt(popText[1].textContent) + 1;

            const inputText = e.currentTarget.value;

            //console.log("Post" + postId);
            //console.log("input:" + inputText);
            const data = {
                comment: inputText,
                post: postId
            };
            
            removeChildsByElements(currentComments);

            fetch("http://localhost/HW/fetchLoadComments.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            }).then(onResponse).then(onJsonNewComment);
        }
    }
}

// Ricerca profili

function searchContent(e)
{
    if(e.code == "Enter")
    {
        const queryString = e.currentTarget.value;
        window.sessionStorage.setItem("user", queryString);
        removeChildsByQuery("section .post");
        fetch("searchProfile.php?qString=" + encodeURIComponent(queryString)).then(onResponse).then(onJson);
    }
}

const inputSearch = document.querySelector("nav .menu .search-box");
inputSearch.addEventListener('keyup', searchContent);


// Utilità

// Funzione per rimuovere tutti i child element di una specifica query Selector
function removeChildsByQuery(query)
{
    const elems = document.querySelectorAll(query);

    for(let elem of elems)
    {
        elem.remove();
    }
}

function removeChildsByElements(els)
{
    const elems = els;

    for(let elem of elems)
    {
        elem.remove();
    }
}