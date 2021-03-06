<?php
namespace Pbxg33k\UtorrentClient\Model;

class SettingItem extends BaseModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * 0 = Integer
     * 1 = Boolean
     * 2 = String
     *
     * http://help.utorrent.com/customer/en/portal/articles/1573945-modifying-settings---webapi
     *
     * @var int
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $value;

    public function fromJson($json, array $filter = null)
    {
        $this->name = $json[0];
        $this->type = $json[1];
        $this->value = $json[2];

        switch ($this->type) {
            case 0;
                $this->value = (int)$this->value;
                break;
            case 1;
                $this->value = $this->value == 'true';
        }

        return $this;
    }

    public function toOriginal()
    {
        $value = $this->value;

        // We have to wrap everything in quotes
        switch (gettype($this->value)) {
            case 'numeric':
            case 'integer':
                $value = (string)$this->value;
                break;
            case 'boolean':
                $value = $this->value === true ? "true" : "false";
                break;
        }

        return [
            $this->name,
            $this->type,
            $value
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}