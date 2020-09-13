<template>
    <div class="Dashboard">
        <section class="content">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-4">




                          <div class="card border-info mx-sm-1 p-3 mb-2" v-for="manager in managers">

                              <div class="text-info text-center mt-3"><h4> {{ manager.title }}</h4></div>
                              <div class="text-info text-center mt-2"><h1>{{ manager.value }} </h1></div>
                          </div>

                  </div>
                  <div class="col-sm-8">
                      <div class="container">
                          <div class="row">
                              <div class="card border-danger golge">
                                  <div class="card-header"><a href="anasayfa.html" class="isteColor">
                                      <h5 class="text-center m-2" style="font-weight: bold">NOTÍCIAS</h5>
                                  </a></div>
                                  <div class="card-body gfg">
                                      <div class="carousel vert slide " data-ride="carousel" data-interval="2000">
                                          <div class="carousel-inner">
                                              <div class="carousel-item active">
                                                  <ul class="timeline">
                                                      <li v-for="feed in feeds">
                                                          <!--"_blank" tıklanan linkin yeni sekmede açılmasını sağlar.-->
                                                          <a target="_blank" href="#">{{ feed.title }}</a>
                                                          <a href="#" class="float-right">{{ feed.pubDate }}</a>
                                                          <p class="article">>{{ feed.description | truncate(30, '...') }}</p>
                                                      </li>
                                                  </ul>
                                              </div>

                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                managers : {},
                feeds: {}
            }
        },
        methods: {
            loadmanagers(){
                axios.get("../api/v1/managers").then(({ data }) => (this.managers = data.data));
            },
            loadFeed(){
                axios.get("../api/feed").then(({ data }) => (this.feeds = data));
            },
        },
        created() {
            this.loadmanagers();
            this.loadFeed();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
    };
</script>
