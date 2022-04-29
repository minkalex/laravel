<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Chat</title>
</head>
<body>

<div class="row" style="flex-wrap: unset; margin: unset;" id="vue-users-menu">
    <div class="list-group col-4 list-group-flush" style="padding: unset">

        <div id="app">
            <create-chat-button></create-chat-button>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="pencil" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd"
                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </symbol>
        </svg>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false" data-bs-auto-close="outside">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img">
                    <use xlink:href="#pencil"/>
                </svg>
                new chat
            </button>
            <ul class="dropdown-menu">
                <div class="accordion accordion-flush" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                step #1
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                    @foreach($users as $user)
                                        @if ($user->id !== Auth::user()->id)
                                            <li class="list-group-item"><input class="form-check-input me-1"
                                                                               type="checkbox" value="">
                                                {{ $user->full_name }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                step #2
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="chat-title" name="chat-title"
                                           placeholder="chat title">
                                    <label for="chat-title">chat title</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                step #3
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <button type="button" class="btn btn-link text-decoration-none link-success">create
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
        <div class="list-group list-group-flush" id="list-tab" role="tablist">
            @foreach($chats as $chat)
                <a class="list-group-item list-group-item-action d-flex justify-content-between" id="list-home-list"
                   data-bs-toggle="list"
                   href="#list-chat-{{ $chat->id }}" role="tab"
                   aria-controls="list-chat-{{ $chat->id }}">
                    {{ $chat->title }}
                    <span class="badge bg-primary rounded-pill">14</span>
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-8" style="padding: unset">
        <div class="tab-content" id="nav-tabContent">
            @foreach($chats as $chat)
                <div class="tab-pane fade"
                     id="list-chat-{{ $chat->id }}" role="tabpanel"
                     aria-labelledby="list-chat-{{ $chat->id }}-list">
                    <div class="list-group list-group-flush">
                        @foreach($chat->messages as $message)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ \App\Models\User::find($message->user_id)->full_name }}</h5>
                                    <small class="text-muted">{{ $message->created_at }}</small>
                                </div>
                                <p class="mb-1">{{ $message->text }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="input-group position-absolute bottom-0" style="width: 66.6%">
                        <input type="text" class="form-control" placeholder="write a message..."
                               aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-success" type="button" id="button-addon2">send</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
