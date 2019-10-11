
@extends('layouts.home')

@section('content')

<h1 class="mt-5"></h1>
<p class="lead">
    Former unified cruiserweight champion Oleksandr Usyk makes his heavyweight debut against late replacement Chazz Witherspoon at Wintrust Arena in Chicago on Saturday.
    Usyk was scheduled to face Tyrone Spong, but Spong tested positive for banned substances in two urine samples and Witherspoon was selected as his replacement just a few days before the fight.
    We asked a panel of noted trainers about their thoughts on how the 6-foot-3 Usyk will fare in his move up to the “land of the giants.
</p>

<div id="app-comment">

    <div v-for="(item, key) in comment" :key="item.id" class="row">
        <div v-bind:class="getClassCol(item.depth)">
            <div v-bind:id="'comment-box-' + item.id" class="comment-box">
                <div class="media-body">
                    <h4 class="media-heading">@{{ item.name }}</h4>
                    <p>@{{ item.comment }}</p>
                </div>
                <a v-bind:style="[item.depth >= 2 || comment_last_key == key ? {'visibility':'hidden'} : {}]" class="link-reply" href="javascript:" v-on:click="showForm(item.id)">reply</a>
                <form class="comment-form">
                    <div class="form-group">
                        <input type="text" v-bind:id="'name-' + item.id" class="form-control" name="name" placeholder="Enter your name" required/>
                    </div>
                    <div class="form-group">
                        <textarea v-bind:id="'text-' + item.id" class="form-control" name="comment" placeholder="Enter your comment" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-save btn-primary float-right" v-on:click="saveComment(item.id)"><i v-if="is_loading.d" class='fa fa-spinner fa-spin'></i>Save</button>
                        <button type="button" class="btn btn-cancel btn-outline-secondary float-right" v-on:click="hideForm(item.id)">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="comment-box-0" class="comment-box">
            <div class="col-md-12">
                <form class="comment-form">
                    <div class="form-group">
                        <input type="text" id="name-0" class="form-control" name="name" placeholder="Enter your name" required/>
                    </div>
                    <div class="form-group">
                        <textarea id="text-0" class="form-control" name="comment" placeholder="Enter your comment" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-save btn-primary float-right" v-on:click="saveComment(0)"><i v-if="is_loading.s" class='fa fa-spinner fa-spin'></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('css')
<style type="text/css">


</style>
@endpush

@push('script')

<script type="text/javascript">

    var vueComment = new Vue({
        el:'#app-comment',
        data:{
            is_loading: {
                d : false,
                s : false,
            },
            comment: [],
        },
        created : function () {

            axios.post('/home/get', {
            })
            .then(response => {
                if(response.data){

                    this.comment = this.changeData(response.data.data);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        methods: {
            showForm : function (id) {

                let box = document.getElementById('comment-box-' + id);
                let link = box.getElementsByClassName("link-reply")[0];
                let form = box.getElementsByClassName("comment-form")[0];

                link.style.display = "none";
                form.style.display = "block";
            },
            hideForm : function (id) {

                let box = document.getElementById('comment-box-' + id);
                let link = box.getElementsByClassName("link-reply")[0];
                let form = box.getElementsByClassName("comment-form")[0];
                let prefix = id ? 'd' : 's';

                link.style.display = "block";
                form.style.display = "none";

                document.getElementById('name-' + id).value = "";
                document.getElementById('text-' + id).value = "";

                this.is_loading[prefix] = false;
            },
            saveComment : function (id) {

                let box = document.getElementById('comment-box-' + id);
                let form = box.getElementsByClassName("comment-form")[0];
                var prefix = id ? 'd' : 's';

                this.is_loading[prefix] = true;

                if(form.checkValidity()){

                    axios.post('/home/add', {
                        parent_id : id,
                        name : document.getElementById('name-' + id).value,
                        comment : document.getElementById('text-' + id).value,
                        _token : "{{ csrf_token() }}",
                    })
                    .then(response => {
                        if(response.data.status == "ok"){

//                            var key;
//                            var find = false;
//                            var length = this.comment.length - 1;
//
//                            for(var i in this.comment){
//                                if(this.comment[i].id == id){
//
//                                    if(length <= i){
//
//                                        key = i;
//                                        key ++;
//                                        find = true;
//
//                                        continue;
//                                    }
//
//                                    var depth = this.comment[i].depth;
//                                    depth ++;
//
//                                    for(var j = i; length >= j; j++){
//
//                                        if(this.comment[j].depth != depth){
//
//                                            key = i;
//                                            key ++;
//                                            find = true;
//
//                                            continue;
//                                            continue;
//                                        }
//                                    }
//                                }
//                            }
//                            if(find){
//                                this.comment.splice(key, 1, response.data.data);
//                            } else {
//                                this.comment.splice(this.comment.length, 1, response.data.data);
//                            }

                            this.hideForm(id);
                            this.comment = this.changeData(response.data.data);

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                    this.is_loading[prefix] = false;
                } else {
                    this.is_loading[prefix] = false;
                    form.classList.add('was-validated');
                }

            },
            getClassCol : function (deep) {
                return "col-md-" + (12 - deep) + " offset-md-"+deep;
            },
            changeData : function (data) {

                var i = -1;
                var i1 = 0;
                var i2 = 0;

                var result = [];

                if(data) {
                    for (var l in data) {

                        i++;
                        result[i] = data[l];

                        if (data[l].children) {
                            i1 = i;
                            for (var l1 in data[l].children) {

                                i++;
                                result[i] = data[l].children[l1];


                                if (data[l].children[l1].children) {
                                    i2 = i;
                                    for (var l2 in data[l].children[l1].children) {

                                        i++;
                                        result[i] = data[l].children[l1].children[l2];
                                    }
                                    delete result[i2].children;
                                }
                            }
                            delete result[i1].children;
                        }
                    }
                }

                return result;
            }
        },
        computed: {

            comment_last_key: function () {

                return this.comment.length - 1;
            }
        }
    });

    window.document.onload = function(e){};

</script>
@endpush