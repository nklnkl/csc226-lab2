# Class constraints
  - Services favor isolated testing, and make no use of integrated data.
  - Services are static and do not communicate directly with the data storage
    layer. Hence the functions are static, and do not refer to the Json classes.
    Therefore they take data, may modify them, and return them. The Application
    using these classes may then save volatile data at their respective level.
  - Services make minimal use of associative arrays as objects. Rather they
    transform given associative arrays into Class objects and use the methods
    set by the class.
