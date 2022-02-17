{if $comment.id_smart_blog_comment != ''}
<ul class="comment">
    <div id="comment-{$comment.id_smart_blog_comment}">
                                        <li class="even">
											<div class="avatar"><img alt="Avatar" src="{$modules_dir}/smartblog/images/avatar/avatar-author-default.jpg"></div>
										  <div class="text">
												<div class="name">{$childcommnets.name}</div>
												<div class="bgr_cm">
													  <div class="created">
														 <span itemprop="commentTime"> {$childcommnets.created|date_format:"%d %b %Y"} / </span>
													  </div>
													  <div class="reply">
														   <a onclick="return addComment.moveForm('comment-{$comment.id_smart_blog_comment}', '{$comment.id_smart_blog_comment}', 'respond', '{$smarty.get.id_post}')"  class="comment-reply-link">Reply</a>
													 </div>
												</div>
											  <p>{$childcommnets.content}</p>
											  {if Configuration::get('smartenablecomment') == 1}
												{if $comment_status == 1}
										  </div>
                                          
                            
                                            {/if}
                                          {/if}
                        {if isset($childcommnets.child_comments)}
                            	{foreach from=$childcommnets.child_comments item=comment}  
                                   {if isset($childcommnets.child_comments)}
                                    {include file="./comment_loop.tpl" childcommnets=$comment}
                        
                                    {$i=$i+1}
                                    
                                        {/if}
                                {/foreach}
                         {/if}
                                        </li>
    </div>
</ul>
                                        {/if}
                                        
                                        