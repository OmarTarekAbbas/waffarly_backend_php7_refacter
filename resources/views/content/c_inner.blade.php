{{-- <tbody>
                                    @foreach($contents as $value)
                                    <tr>
                                        <td><input class="select_all_template" type="checkbox" name="selected_rows[]" value="{{$value->id}}" class="roles" onclick="collect_selected(this)"></td>
                                        <td>{{$value->id}}</td>
                                        <td>
                                            {{$value->title}}
                                        </td>
                                        <td>
                                          @if($value->type->id == 1)
                                          {!! $value->path !!}
                                          @elseif($value->type->id == 2)
                                          {{$value->path}}
                                          @elseif($value->type->id == 3)
                                          <img src="{{$value->path}}" alt="" style="width:250px" height="200px">
                                          @elseif($value->type->id == 4)
                                          <audio controls src="{{$value->path}}" style="width:100%"></audio>
                                          @elseif($value->type->id == 5)
                                          <video src="{{$value->path}}" style="width:250px;height:200px" height="200px" controls poster="{{$value->image_preview}}"></video>
                                          @elseif($value->type->id == 6)
                                          <iframe src="{{$value->path}}" width="250px" height="200px"></iframe>
                                          @endif
                                        </td>
                                        @if(!isset($category))
                                        <td>
                                            {{$value->category->title}}
                                        </td>
                                        @endif
                                        <td>{{$value->type->title}}</td>
                                        <td>{{$value->patch_number}}</td> --}}
                                        <td class="visible-md visible-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-success show-tooltip" title="Add Post" href="{{url("post/create?content_id=".$value->id."&title=".$value->title)}}" data-original-title="Add Post"><i class="fa fa-plus"></i></a>
                                                @if(count($value->operators) > 0)
                                                <a class="btn btn-sm show-tooltip" title="Show Posts" href="{{url("content/$value->id")}}" data-original-title="show Posts"><i class="fa fa-step-forward"></i></a>
                                                @endif
                                                <a class="btn btn-sm show-tooltip" href="{{url("content/$value->id/edit")}}" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-sm show-tooltip btn-danger" onclick="return ConfirmDelete();" href="{{url("content/$value->id/delete")}}" title="Delete"><i class="fa fa-trash"></i></a>
                                                @if($value->type->id == 4)
                                                <a class="btn btn-sm btn-info show-tooltip" title="Add Rbt" href="{{url("rbt/create?content_id=".$value->id."&title=".$value->title)}}" data-original-title="Add RBt"><i class="fa fa-plus"></i></a>
                                                @endif
                                                @if(count($value->rbt_operators) > 0)
                                                <a class="btn btn-sm show-tooltip" title="Show Rbt Code" href="{{url("rbt/$value->id")}}" data-original-title="show RBt_code"><i class="fa fa-step-forward"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    {{-- </tr>
                                    @endforeach
                                </tbody> --}}