<?php
namespace MyApp\helpers;
trait connection
{
    private $connections = [USER => [],LISTENER => [],BOTH => []];
    private $tokens = [];
    private $request;
    private $type;
    private function register_connection($connection)
    {
        $this->attach_connection($connection);
        if(!$this->is_register_connection($connection)) $this->tokens[$connection->resourceId] = $this->get_socket_key($connection);
    }
    private function unset_connection($connection)
    {
		$this->detach_connection($connection);
        if(isset($this->tokens[$connection->resourceId])) unset($this->tokens[$connection->resourceId]);
        $connection->close();
    }
    private function is_register_connection($connection)
    {
        return (isset($this->tokens[$connection->resourceId]) && $this->is_valid_token($connection));
    }
    private function attach_connection($connection)
    {
        $query = $this->handle_query($connection);
        $this->connections[$query['permission']][$query['id']] = $connection;
    }
    private function detach_connection($connection)
    {
        $query = $this->handle_query($connection);
        unset($this->connections[$query['permission']][$query['id']]);
    }
    private function is_valid_token($connection)
    {
        return $this->get_socket_key($connection) == $this->tokens[$connection->resourceId];
    }
    private function get_socket_key($connection)
    {
        return $connection->httpRequest->getHeaders()["Sec-WebSocket-Key"][0];
    }

    /**
     * Take A Connection Type Of Connection Interface
     * Store Connection Query In Request Property
     */
    private function handle_query($connection)
    {
		$querystring = $connection->httpRequest->getUri()->getQuery();
		parse_str($querystring,$request);
        return $request;
    }
}