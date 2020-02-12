<template>
    <div>
        <h2>Articles</h2>
        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <input v-model="article.title" type="text" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
                <textarea v-model="article.body" type="text" class="form-control" placeholder="Body"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li :class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a @click="fetchArticles(pagination.prev_page_url)" class="page-link" href="#">Previous</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a>
                </li>
                <li :class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a @click="fetchArticles(pagination.next_page_url)" class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="article in articles" :key="article.id">
            <h3>{{ article.title }}</h3>
            <p>{{ article.body }}</p>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <button @click="editArticle(article)" class="btn btn-warning w-100">Edit</button>
                </div>
                <div class="col-md-6">
                    <button @click="deleteArticle(article.id)" class="btn btn-danger w-100">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'articles',
    data: () => ({
        articles: [],
        article : {
            id   : '',
            title: '',
            body : ''
        },
        article_id: '',
        pagination: {},
        edit: false
    }),
    created() {
        this.fetchArticles();
    },
    methods: {
        fetchArticles(page_url) {
            let vm = this;
            page_url = page_url || 'api/articles'
            // fetch('api/articles')
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err))
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination;
        },
        deleteArticle(id) {
            if(confirm('Are You Sure?')) {
                fetch(`api/article/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Article Removed');
                    this.fetchArticles();
                })
                .catch(err => console.log(err))
            }
        },
        addArticle() {
            if(this.edit === false) {
                // Add
                fetch('api/article', {
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    },
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('Article Added');
                    this.fetchArticles();
                })
                .catch(err => console.log(err))
            } else {
                // Update
                fetch('api/article', {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    },
                })
                .then(res => res.json())
                .then(data => {
                    this.article.title = '';
                    this.article.body = '';
                    alert('Article Updated');
                    this.fetchArticles();
                })
                .catch(err => console.log(err))
            }
        },
        editArticle(article) {
            this.edit               = true;
            this.article.id         = article.id;
            this.article.article_id = article.id;
            this.article.title      = article.title;
            this.article.body       = article.body;
        }
    }
}
</script>