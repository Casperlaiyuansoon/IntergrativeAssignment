<?php
class CommandInvoker {
    private $command;

    public function setCommand(Command $command) {
        $this->command = $command;
        return $this; // Return $this to allow method chaining
    }

    public function executeCommand() {
        if ($this->command === null) {
            throw new Exception("No command set");
        }
        return $this->command->execute();
    }
}
?>
