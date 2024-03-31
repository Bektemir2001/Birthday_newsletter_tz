<!-- Modal -->
<div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создать рассылку</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label id="checked_users"></label>
                </div>
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="msg">Сообщение</label>
                    <textarea class="form-control" id="msg" name="msg"></textarea>
                </div>
                <p id="error_msgId" class="text-danger"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-primary" onclick="sendMail()">Создать</button>
            </div>
        </div>
    </div>
</div>
