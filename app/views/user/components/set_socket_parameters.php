<script>
    window._token = "<?=$this->get_web_socket_token()?>";
    window.permission = "<?=$this->get_session("permission")?>";
    window.user_id = "<?=$this->get_session("id")?>";
    window.current_page = "<?=$this->active_page?>";
</script>