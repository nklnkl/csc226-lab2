# Constraints
  - API handlers must initialize data to be sent to HTTP::respond.
    - $status - http response code.
    - $body - array of response data.
    - $header - string of header key values. these values must be concatenated.
  - HTTP::response must only be called once at the end of the API Handlers' code.
  - API handler functions merely modify the initialized data, and send it at the
  end of the file.
