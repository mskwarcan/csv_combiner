<?php
  class File {
    public $file_name;
    public $file_extension;
    public $file_headers;
    public $file_path;
    public $file_row_data;
    
    public function __construct($file_path) {
      $this->file_exists($file_path);
      $this->file_extension_check();
      $this->set_file_row_data();
    }
    
    // SETTERS AND GETTERS
    private function set_file_name($name) {
      $this->file_name = $name;
    }
    
    public function get_file_name() {
      return $this->file_name;
    }
    
    private function set_file_path($path) {
      $this->file_path = $path;
    }
    
    public function get_file_path() {
      return $this->file_path;
    }
    
    private function set_file_extension($ext) {
      $this->file_extension = $ext;
    }
    
    public function get_file_extension() {
      return $this->file_extension;
    }
    
    private function set_file_headers($headers) {
      // Add Filename to data
      array_push($headers, 'filename');
      
      // Join with commas
      $this->file_headers = join(',', $headers);
    }
    
    public function get_file_headers() {
      return $this->file_headers;
    }
    
    private function set_file_row_data() {
      $csv = fopen($this->get_file_path(), 'r');
      $this->set_file_headers(fgetcsv($csv));
      $row_data = array();
      
      while (($data = fgetcsv($csv)) !== FALSE) {
        array_push($row_data, $this->parse_row($data));
      }
      
      fclose($csv);
      
      $this->file_row_data = $row_data;
    }
    
    public function get_file_row_data() {
      return $this->file_row_data;
    }
    
    // DATA MANIPULATION
    private function parse_row($data) {
      // Add Filename to data
      array_push($data, $this->get_file_name());
      
      // Join with commas
      return join(',', $data);
    }
    
    // FILE VALIDATION  
    private function file_exists($file_path) { 
      if(!file_exists($file_path)) {
        print "The " .$file_path. " file was does not found.\n";
        exit;
      } else {
        // Set Filepath and filename
        $this->set_file_path($file_path);
        $filename = pathinfo($file_path, PATHINFO_BASENAME);
        $this->set_file_name($filename);
      }
    }
    
    private function file_extension_check() {
      $valid_files_types = array('csv');
      $error_message = "The %s file you included is not a CSV file.\n";
      
      // Get File extenstion and compare against valid file types
      $ext = pathinfo($this->get_file_path(), PATHINFO_EXTENSION);
      if(!in_array($ext, $valid_files_types)) {
        print sprintf($error_message, $file);
        exit;
      } else {
        $this->set_file_extension($ext);
      }
    }
    
    // DEBUGGING
    public function fileState() {
      print_r($this->get_file_path());
      print_r("\n");
      print_r($this->get_file_name());
      print_r("\n");
      print_r($this->get_file_extension());
      print_r("\n");
      print_r($this->get_file_headers());
      print_r("\n");
      print_r($this->get_file_row_data());
    }
  }
?>