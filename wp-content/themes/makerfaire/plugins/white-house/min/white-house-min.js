jQuery(document).ready(function($){posts_url="https://public-api.wordpress.com/rest/v1/sites/makezine.com/posts/?tag=white-house-maker-faire",$.getJSON(posts_url,function(t){the_posts=t.posts,output='<div class="row">',$.each($(the_posts),function(t,u){console.log(u),output+='<div class="col-md-3">',output+='<a href="'+u.URL+'">',output+='<img class="img-thumbnail" src="'+u.featured_image+'?w=220&h=160&crop=1">',output+="</a>",output+='<a href="'+u.URL+'">',output+="<h4>"+u.title+"</h4>",output+="</a>",output+=u.excerpt,(t+1)%4?output+="</div>":output+='</div></div><div class="row">'}),output+="</div>",$("section.posts").html(output)})});