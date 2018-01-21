<?php
namespace Zing\Core\CoreBundle\CoreInterface;

interface ZingEntityInterface {

    /** Set item date added
     *  @param int $date_added Unixtime
     */
    public function setDateAdded($date_added);
    public function getDateAdded();

    /** Set item date modified
     *  @param int $date_modified Unixtime
     */
    public function setDateModified($date_modified);
    public function getDateModified();

    /** Set item status
     * @param bool $status
     */
    public function setStatus($status);
    public function getStatus();

}