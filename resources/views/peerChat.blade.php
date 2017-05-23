@extends('layouts.app')

@section('yow')

<div class="container">
    <div class="row">
        <div id="app" class="col-md-6">
            <div class="panel panel-default">
            @if(Auth::user()->roles == 'agent')
                <div class="panel-heading">Public</div>
                <div class="panel-body">
                    <chat-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                    ></chat-form>
                </div>
            </div>
            @else
                <div class="panel-heading">Public</div>
                <div class="panel-body">
                    <chat-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                        :recipient= "{{ $recipient }}"
                    ></chat-form>
                </div>
            </div>
            @endif
        </div>
        <div id = "app2">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Private</div>

                <div class="panel-body">
                    <private-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <private-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                        :room="{{ $room->id }}"
                    ></private-form>
                </div>
            </div>
        </div>
        </div>
        <input type ="text" id = "recipient" value = " {{$recipient->id}}"/>
        <input type ="text" id = "room" value = " {{$room->id}}"/>
    </div>
</div>
</div>

<script>
    var recipient = {!! $recipient->id !!};
    var userData = {!! Auth::user() !!};
    var vueData = {!! $room !!};
</script>
@endsection