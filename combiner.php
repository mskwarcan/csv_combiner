<?php
  require_once 'file.php';

  class Combiner {
    public $files;
    
    public function __construct() {
      $file_paths = $this->get_file_paths(getopt("d:f:"));
      $this->create_files($file_paths);
      $this->header_check();
      $this->output_rows();
    }
    
    // SETTERS AND GETTERS
    private function set_files($files) {
      $this->files = $files;
    }
    
    private function get_files() {
      return $this->files;
    }
    
    private function create_files($file_paths) {
      $files = array();
      foreach($file_paths as $file) {
        array_push($files, new File($file));
      }
      $this->set_files($files);
    }
    
    // Get File Paths from Options
    private function get_file_paths($options) {
      $file_paths = array();
      $filenames = $options[f];
      $directories = $options[d];
      
      // Add all individual files to the arary to pull from
      if(isset($filenames)) {
        if(is_array($filenames)) {
          $file_paths = array_merge($file_paths, $filenames);
        } else {
          array_push($file_paths, $filenames);
        }
      }
      
      // Add all the files in the directories passed in
      if(isset($directories)) {
        $directory_files = $this->get_directory_files($directories);
        $file_paths = array_merge($file_paths, $directory_files);
      }
      
      //remove duplicates and return
      return array_unique($file_paths);
    }
    
    private function get_directory_files($directories) {
      $directory_files = array();
      
      if(is_array($directories)) {
        foreach ($directories as $directory) {
          $directory_file_paths = $this->get_directory_paths($directory);
          
          // Add file paths for each directory
          $directory_files = array_merge($directory_files, $directory_file_paths);
        }
      } else {
        $directory_file_paths = $this->get_directory_paths($directories);
        $directory_files = array_merge($directory_files, $directory_file_paths);
      }
      
      return $directory_files;
    }
    
    private function get_directory_paths($directory) {
      
      // Grab all filenames in directory
      $filenames =  array_diff(scandir($directory), array('.', '..', '.DS_Store'));
      
      // Add directory path to filenames
      $directory_file_paths = $this->get_file_path($directory, $filenames);
      
      return $directory_file_paths;
    }
    
    private function get_file_path($directory_path, $files) {
      $paths = array();
      
      foreach ($files as $file) {
        $file_path = $directory_path . "/" . $file;
        array_push($paths, $file_path);
      }
      
      return $paths;
    }
    
    private function header_check() {
      foreach ($this->get_files() as $file) {
        if(!isset($headers)) {
          $headers = $file->file_headers;
        } else {
          if($headers != $file->file_headers) {
            print "You have differing sets of column headers in the " . $file->file_path . " file.\n";
            exit;
          }
        }    
      }
    }
    
    private function output_rows() {
      foreach ($this->get_files() as $file) {
        if(!isset($headers)) {
          $headers = $file->file_headers;
          print $headers . "\n";
        }
        
        foreach ($file->file_row_data as $row) {
          print $row . "\n";
        }     
      }
    }
  } 
  
  $combiner = new Combiner();
?>