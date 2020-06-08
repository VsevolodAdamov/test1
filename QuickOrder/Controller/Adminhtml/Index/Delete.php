<?php

namespace Level\QuickOrder\Controller\Adminhtml\Index;

use Level\QuickOrder\Controller\Adminhtml\Order as BaseAction;

class Delete extends BaseAction
{
    /** {@inheritdoc} */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);

        if (!empty($id)) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Order has been deleted.'));
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(_('order can\'t delete'));
                return $this->doRefererRedirect();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID)
            );
            $this->messageManager->addMessage(__('No item to delete'));
        }

        return $this->redirectToGrid();
    }
}
