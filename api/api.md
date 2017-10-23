# Constraints
  - API handlers must initialize data to be sent to HTTP::respond.
    - $status - http response code.
    - $body - array of response data.
    - $header - string of header key values. these values must be concatenated.
  - HTTP::response must only be called at the end of every endpoint result.
