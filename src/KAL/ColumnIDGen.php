<?php

class KAL_ColumnIDGen implements KAL_ColumnGeneraterInterface {
    const ID_LONG = "long";
    const ID_TIME = "time";
    const ID_MYSQL = "mysql";

    private $type;
    private $options;

    public function __construct($type_name, array $options) {
        $constant_name = "self::ID_".strtoupper($type_name);
        if (! defined($constant_name)) {
            throw new InvalidArgumentException('invalid idgen type "'.$type_name.'"');
        }

        $this->type = constant($constant_name);
        if (in_array($this->type, array(self::ID_LONG, self::ID_TIME))) {
            if (!isset($options["kind"])) {
                throw new InvalidArgumentException('idgenerator kind name needed in argument 2');
            }
            if (!$options["idgen"]) {
                $options["idgen"] = "";
            }
        }
        $this->options = $options;
    }

    public function generate() {
        $value = false;
        switch ($this->type) {
            case self::ID_MYSQL:
                $value = 0;
                break;
            case self::ID_LONG:
                $dkxi_id = new DKXI_ID::factory($this->options["idgen"]);
                $value = $dkxi_id->newId($this->options["name"]);
                break;
            case self::ID_TIME:
                $dkxi_id = new DKXI_ID::factory($this->options["idgen"]);
                $value = $dkxi_id->newTimeId($this->options["name"]);
                break;
            default:
                break;
        }
        return $value;
    }
}