const divComment = document.getElementById("comments")
const textarea = document.getElementById("textarea")
const addBtn = document.getElementById("add_btn")

const baseurl = document.body.dataset.baseurl
const currentUser = document.body.dataset.current
const blogId = document.body.dataset.blogid
const authorBlog = document.body.dataset.author

function getData(){
    axios.get(`${baseurl}/api/comment/list.php?id=${blogId}`)
    .then(res =>{
        console.log(res.data)
        showComment(res.data)
    })
}
getData()

function showComment(comments){
    let divHtml = `<h2> ${comments.length} комментария</h2>`
    
    for(let item of comments){
        let deleteComment = ``
        if(currentUser == item['author_id'] ||
        currentUser == authorBlog){
            deleteComment = `<div class="comment-delete" onclick="removeComment(${item['id']})"> Delete</div>`
        }
        divHtml += `
        <div class="comment">
            <div class="comment-header">
                <div class="comment-header-info"> 
                    <img src="images/avatar.png" alt="">
                    ${item.full_name}
                </div>
                ${deleteComment}
            </div>
            <p>${item.text}</p>
        </div>
        `
    }

    divComment.innerHTML = divHtml
}

addBtn.onclick = () =>{
    axios.post(`${baseurl}/api/comment/add.php`,{
        text:textarea.value,
        blog_id:blogId,
        author_id:currentUser
    }).then(res =>{
        getData()
        textarea.value = ""
    })
}

function removeComment(id){
    axios.delete(`${baseurl}/api/comment/delete.php?id=${id}`)
    .then(res =>{
        getData()
    })
}


