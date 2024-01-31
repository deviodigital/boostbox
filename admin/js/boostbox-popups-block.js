const { registerBlockType } = wp.blocks;
const { SelectControl, Button } = wp.components;
const { withSelect, withDispatch } = wp.data;

const BoostBoxPopupsBlock = registerBlockType('boostbox/popups-block', {
    title: wp.i18n.__('BoostBox Popups', 'boostbox'),
    icon: 'cover-image',
    category: 'common',
    attributes: {
        selectedPopup: {
            type: 'number',
            default: 0,
        },
    },
    edit: withSelect((select) => {
        return {
            posts: select('core').getEntityRecords('postType', 'boostbox_popups') || [],
            currentPostId: select('core/editor').getCurrentPostId(),
            selectedBlockClientId: select('core/block-editor').getSelectedBlockClientId(),
        };
    })(
        withDispatch((dispatch) => {
            return {
                replaceBlocks: dispatch('core/block-editor').replaceBlocks,
                removeBlocks: dispatch('core/block-editor').removeBlocks,
            };
        })(({ posts, attributes, setAttributes, replaceBlocks, removeBlocks, currentPostId, selectedBlockClientId }) => {
            const onInsertClick = async () => {
                if (attributes.selectedPopup !== 0) {
                    const post = posts.find((p) => String(p.id) === String(attributes.selectedPopup));

                    if (post && currentPostId) {
                        try {
                            // Check if the selected post is the current post
                            if (currentPostId === attributes.selectedPopup) {
                                console.log(wp.i18n.__('Selected post is the current post. Do nothing.', 'boostbox'));
                                return;
                            }

                            // Use getEntityRecord selector to get the post content
                            const postContent = wp.data.select('core').getEntityRecord('postType', 'boostbox_popups', post.id).content.raw;

                            // Parse the HTML content into blocks
                            const parsedBlocks = wp.blocks.parse(postContent);

                            // Add a custom class to the first block
                            if (parsedBlocks.length > 0) {
                                parsedBlocks[0].attributes = {
                                    ...parsedBlocks[0].attributes,
                                    className: `boostbox-popup-${post.id}`,
                                };
                            }

                            // Replace the entire content of the selected block with the parsed blocks
                            replaceBlocks(selectedBlockClientId, parsedBlocks);

                            // Remove existing BoostBox Popups block
                            removeBlocks(selectedBlockClientId);
                        } catch (error) {
                            console.error(wp.i18n.__('Error fetching post content:', 'boostbox'), error);
                        }
                    }
                }
            };

            const options = [
                { label: wp.i18n.__('--', 'boostbox'), value: 0 },
                ...posts.map((post) => ({
                    label: post.title.raw,
                    value: post.id,
                })),
            ];

            return wp.element.createElement(
                'div',
                null,
                wp.element.createElement('h2', null, wp.i18n.__('BoostBox Popups', 'boostbox')),
                wp.element.createElement(SelectControl, {
                    label: wp.i18n.__('Select a BoostBox Popup', 'boostbox'),
                    value: attributes.selectedPopup,
                    options,
                    onChange: (value) => setAttributes({ selectedPopup: value }),
                }),
                wp.element.createElement(
                    Button,
                    {
                        onClick: onInsertClick,
                        isPrimary: true,
                    },
                    wp.i18n.__('Insert', 'boostbox')
                )
            );
        })
    ),
    save: () => null, // Save content handled by PHP on the server side
});
