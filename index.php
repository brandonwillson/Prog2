/*
     * Documentation comments...
     *
     * This method inserts one record into the database table, 
     * and redirects user to List screen (if user input is valid), 
     * otherwise this method redirects user back to Create form, with errors
     *
     *   3PIO Comments...
     *
     * - Input: user data from Create form
     * - Processing: INSERT (SQL)
     * - Output: None (This method does not generate HTML code,
     *   it only changes the content of the database)
     * - Precondition: Public variables set (name, email, mobile)
     *   and database connection variables are set in database.php.
     * - Postcondition: New record is added to the database table, 
     *   and user is redirected to the List screen (if no errors), 
     *   or Create form (if errors)
     *
     *   Clarification comment... 
     * - Note that $id will NOT be used in this method because the record 
     *   will be a new record so the SQL database will "auto-number"
     */
    function insert_db_record () {
        // ... below is another clarification comment... 
        // Note: error fields are set in fieldsAllValid () method
        if ($this->fieldsAllValid ()) { // validate user input
            // if valid data, insert record into table
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO $this->tableName (name,email,mobile) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->name,$this->email,$this->mobile));
            Database::disconnect();
            header("Location: $this->tableName.php"); // go back to "list"
        }
        else {
            // if not valid data, go back to "create" form, with errors
            $this->create_record(); 
        }
    } // end function insert_db_record